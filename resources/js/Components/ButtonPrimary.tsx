import { MouseEvent } from "react";
import { withAsyncButton } from "./HOC/WithAsyncButton";
import { withFormButton } from "./HOC/WithFormButton";
import { withNavButton } from "./HOC/WithNavButton";

type Props = {
  text: string
  disabled?: boolean,
  loading?: boolean,
  full?: boolean,
  onClick?: (_e: MouseEvent<HTMLElement>) => void
}

export const ButtonPrimary = ({text, disabled, loading, full, onClick}: Props) => {
  if (disabled) {
    return (
      <div className={`inline-flex select-none border rounded-2lg py-3 px-4 border-border bg-gradient-to-r font-bold from-primary to-accent text-white opacity-60 cursor-not-allowed text-sm ${full ? 'w-full' : ''}`}>
        {text}
      </div>
    );
  }

  if (loading) {
    return (
      <div className={`inline-flex select-none border rounded-2lg py-3 px-4 border-border bg-gradient-to-r font-bold from-primary to-accent text-white cursor-wait text-sm ${full ? 'w-full' : ''}`}>
        Wczytywanie...
      </div>
    )
  }

  return (
    <button 
      className={`inline-flex border select-none rounded-2lg py-3 px-4 border-border bg-gradient-to-r font-bold from-primary to-accent text-white cursor-pointer text-sm transition-transform hover:scale-95 active:scale-105 ${full ? 'w-full' : ''}`}
      onClick={onClick}
    >
      {text}
    </button>
  );
}

export const NavButtonPrimary = withNavButton<Props>(ButtonPrimary);
export const AsyncButtonPrimary = withAsyncButton<Props>(ButtonPrimary);
export const FormButtonPrimary = withFormButton<Props>(ButtonPrimary);
