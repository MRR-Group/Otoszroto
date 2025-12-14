import React, { useState } from "react";

type NavButtonExtraProps = {
  asyncAction: () => Promise<void>;
  onFinally?: () => void;
  onError?: (err: unknown) => void;
  disabled?: boolean;
};

export function withAsyncButton<P>(
  Visual: React.ComponentType<P>
) {
  return function AsyncButton(props: P & NavButtonExtraProps) {
    const { asyncAction, onError, onFinally, disabled, ...rest } = props;
    const [loading, setLoading] = useState(false);

    const onClick = async () => {
      if (disabled) {
        return;
      }
      
      setLoading(true);

      try {
        await asyncAction();
      } catch (err) {
        onError?.(err);
      } finally {
        setLoading(false);
        onFinally?.();
      }
    };

    if (disabled) {
      return <Visual {...(rest as any)} disabled />;
    }

    return (
      <Visual
        {...(rest as P)}
        loading={loading as any}
        onClick={onClick as any}
      />
    );
  };
}
