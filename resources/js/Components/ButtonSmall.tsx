import { withAsyncButton } from "./HOC/WithAsyncButton"
import { withFormButton } from "./HOC/WithFormButton"
import { withNavButton } from "./HOC/WithNavButton"

type Props = {
  text: string
  disabled?: boolean,
  color?: "default" | "ok" | "warn" | "danger"
  loading?: boolean,
  full?: boolean,
  onClick?: () => void
}

export const ButtonSmall = ({text, disabled, color="default", full, loading, onClick}: Props) => {
  const colorClass = {"default": "bg-panel", "ok": "bg-ok", "warn": "bg-warn", danger: "bg-danger" }[color];

  if (disabled) {
    return (
      <div className={`inline-flex justify-center items-center select-none border rounded-2lg w-9 h-9 border-border text-text opacity-60 cursor-not-allowed text-sm ${colorClass} ${full ? 'w-full' : ''}`}>
        {text}
      </div>
    );
  }

  if (loading) {
    return (
      <div className={`inline-flex justify-center items-center select-none border rounded-2lg w-9 h-9 border-border text-text cursor-wait text-sm ${colorClass} ${full ? 'w-full' : ''}`}>
        Wczytywanie...
      </div>
    )
  }

  return (
    <button 
      className={`inline-flex justify-center items-center select-none border rounded-2lg w-9 h-9 border-border text-text cursor-pointer text-sm transition-transform hover:scale-95 active:scale-105 ${colorClass} ${full ? 'w-full' : ''}`}
      onClick={onClick}
    >
      {text}
    </button>
  );
}

export const NavButtonSmall = withNavButton<Props>(ButtonSmall);
export const AsyncButtonSmall = withAsyncButton<Props>(ButtonSmall);
export const FormButtonSmall = withFormButton<Props>(ButtonSmall);