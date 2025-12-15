import { PropsWithChildren } from "react"

type Props = PropsWithChildren<{
  bold?: boolean,
  className?: string,
}>

export const Text = ({bold, className, children}: Props) => {
  if (bold) {
    return (
      <strong className={`text-text font-extrabold ${className}`}>{children}</strong>
    )
  }

  return (
    <p className={`text-muted ${className}`}>{children}</p>
  )
}