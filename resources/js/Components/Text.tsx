import { PropsWithChildren } from "react"

type Props = PropsWithChildren<{
  bold?: boolean,
  className?: string,
  color?: "text" | "muted" | "ok" | "warn" | "danger" | "primary"
}>

export const Text = ({bold, className="", color="text", children}: Props) => {
  const colorClass = {"text": "text-text", "muted": "text-muted", "ok": "text-ok", "warn": "text-warn", "primary": "text-primary", danger: "text-danger" }[color];

  if (bold) {
    return (
      <strong className={`font-extrabold ${colorClass} ${className}`}>{children}</strong>
    )
  }

  return (
    <p className={`${colorClass} ${className}`}>{children}</p>
  )
}