import { PropsWithChildren } from "react"

type Props = PropsWithChildren<{
  onClick?: () => void
}>

export const Tag = ({children}: Props) => (
  <div className="bg-input border border-border text-text rounded-2lg px-2 py-2.5 cursor-pointer transition-colors hover:text-text/50">
    {children}
  </div>
)