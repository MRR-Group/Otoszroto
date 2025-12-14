import { PropsWithChildren } from "react";

type Props = PropsWithChildren<{
  className?: string,
}>

export const Panel = ({className, children}: Props) => (
  <div className={`bg-gradient-to-b from-[#12161b] to-[#0f141a] border border-border rounded-2xl p-4 ${className}`}>
    {children}
  </div>
);