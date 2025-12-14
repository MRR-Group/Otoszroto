type Props = {
  text: string
  disabled?: boolean,
  color?: "default" | "ok" | "warn" | "danger"
  loading?: boolean,
  onClick?: () => void
}

export const Button = ({text, disabled, color="default", loading, onClick}: Props) => {
  const colorClass = {"default": "bg-panel", "ok": "bg-ok", "warn": "bg-warn", danger: "bg-danger" }[color];

  if (disabled) {
    return (
      <div className={`inline-flex border rounded-2lg py-3 px-4 border-borde text-text opacity-60 cursor-not-allowed text-sm ${colorClass}`}>
        {text}
      </div>
    );
  }

  if (loading) {
    return (
      <div className={`inline-flex border rounded-2lg py-3 px-4 border-border text-text cursor-wait text-sm ${colorClass}`}>
        Wczytywanie...
      </div>
    )
  }

  return (
    <button 
      className={`inline-flex border rounded-2lg py-3 px-4 border-border text-text cursor-pointer text-sm transition-transform hover:scale-95 active:scale-105 ${colorClass}`}
      onClick={onClick}
    >
      {text}
    </button>
  );
}