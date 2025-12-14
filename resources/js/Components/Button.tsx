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

export const Button = ({text, disabled, color="default", full, loading, onClick}: Props) => {
  const colorClass = {"default": "bg-panel", "ok": "bg-ok", "warn": "bg-warn", danger: "bg-danger" }[color];

  if (disabled) {
    return (
      <div className={`inline-flex border rounded-2lg py-3 px-4 border-border text-text opacity-60 cursor-not-allowed text-sm ${colorClass} ${full ? 'w-full' : ''}`}>
        {text}
      </div>
    );
  }

  if (loading) {
    return (
      <div className={`inline-flex border rounded-2lg py-3 px-4 border-border text-text cursor-wait text-sm ${colorClass} ${full ? 'w-full' : ''}`}>
        Wczytywanie...
      </div>
    )
  }

  return (
    <button 
      className={`inline-flex border rounded-2lg py-3 px-4 border-border text-text cursor-pointer text-sm transition-transform hover:scale-95 active:scale-105 ${colorClass} ${full ? 'w-full' : ''}`}
      onClick={onClick}
    >
      {text}
    </button>
  );
}

export const NavButton = withNavButton<Props>(Button);
export const AsyncButton = withAsyncButton<Props>(Button);
export const FormButton = withFormButton<Props>(Button);