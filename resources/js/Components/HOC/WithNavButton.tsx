import React from "react";

type NavButtonExtraProps = {
  href: string;
  target?: string;
  disabled?: boolean
};

export function withNavButton<P>(
  Visual: React.ComponentType<P>
) {
  return function NavButton(props: P & NavButtonExtraProps) {
    const { href, target, disabled, ...rest } = props;

    if (disabled) {
      return <Visual {...(rest as any)} disabled />;
    }

    return (
      <a href={href} target={target} className="flex items-stretch">
        <Visual {...(rest as any)}  />
      </a>
    );
  };
}
