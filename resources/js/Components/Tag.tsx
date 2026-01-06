import { PropsWithChildren } from "react"

type Props = PropsWithChildren<{
  selected?: boolean,
  small?: boolean,
  onClick?: () => void
}>

export const Tag = ({selected, small, onClick, children}: Props) => (
  <div 
    className={`
      bg-input border text-text rounded-2lg cursor-pointer transition-colors hover:text-white/60 hover:border-white/60
      ${small ? "text-xs px-2 py-2" : "px-2 py-2.5"} 
      ${selected ? "border-white" : "border-border"}
    `}
    onClick={onClick} 
  >
    {children}
  </div>
)