import React from "react";
import { router } from "@inertiajs/react";
import { withAsyncButton } from "./WithAsyncButton";

type FormButtonExtraProps = {
  url: string;
  method?: "get" | "post" | "put" | "patch" | "delete";
  data?: Record<string, any>;
  disabled?: boolean;
  onFinish?: () => void;
  onSuccess?: () => void;
  onError?: (_errors: Record<string, string>) => void;
};

export function withFormButton<P>(Visual: React.ComponentType<P>) {
  return function FormButton(props: P & FormButtonExtraProps) {
    const {
      url,
      method = "post",
      data,
      disabled,
      onFinish,
      onSuccess,
      onError,
      ...rest
    } = props;

    const AsyncVisual = withAsyncButton<P>(Visual);

    const sendForm = async () => {
      return new Promise<void>((resolve, reject) => {
        router.visit(url, {
          method,
          data: data ?? {},
          preserveScroll: true,
          preserveState: false,
          onSuccess: () => {
            onSuccess?.();
            resolve();
          },
          onError: (errs) => {
            onError?.(errs as any);
            reject(errs);
          },
          onFinish: () => {
            onFinish?.();
          },
        });
      });
    };

    return (
      <AsyncVisual
        {...(rest as P)}
        disabled={disabled}
        asyncAction={sendForm}
      />
    );
  };
}
