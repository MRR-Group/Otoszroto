import { PropsWithChildren } from "react"

type Props = PropsWithChildren<{
  type?: "h1" | "h2" | "h3" | "bold"
}>

export const Title = ({type = "h3", children}: Props) => {
  if (type === 'h1') {
    return (
      <h1 className="text-text font-bold text-3xl mb-3.5">{children}</h1>
    )
  }

  if (type === 'h2') {
    return (
      <h2 className="text-text font-bold text-xl mb-3">{children}</h2>
    )
  }

  if (type === 'bold') {
    return (
      <strong className="text-text font-extrabold">{children}</strong>
    )
  }

  return (
    <h3 className="text-text font-bold text-lg mb-2.5">{children}</h3>
  )
}