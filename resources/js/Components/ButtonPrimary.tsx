type Props = {
  text: string
  disabled?: boolean,
  loading?: boolean,
  onClick?: () => void
}

export const ButtonPrimary = ({text, disabled, loading, onClick}: Props) => {
  if (disabled) {
    return (
      <div className="inline-flex border rounded-2lg py-3 px-4 border-border bg-gradient-to-l font-bold from-primary to-accent text-white opacity-60 cursor-not-allowed text-sm">
        {text}
      </div>
    );
  }

  if (loading) {
    return (
      <div className="inline-flex border rounded-2lg py-3 px-4 border-border bg-gradient-to-l font-bold from-primary to-accent text-white cursor-wait text-sm">
        Wczytywanie...
      </div>
    )
  }

  return (
    <button 
      className="inline-flex border rounded-2lg py-3 px-4 border-border bg-gradient-to-l font-bold from-primary to-accent text-white cursor-pointer text-sm transition-transform hover:scale-95 active:scale-105"
      onClick={onClick}
    >
      {text}
    </button>
  );
}