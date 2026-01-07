import React from "react";

type Props = {
  value?: string, 
  name?: string,
  placeholder?: string,
  password?: boolean,
  email?: boolean,
  required?: boolean,
  full?: boolean,
  onChange?: (_e: React.ChangeEvent<HTMLTextAreaElement>) => void,
  onBlur?: () => void,
}

export const MultilineInput = ({value, name, placeholder, required, full, onChange, onBlur}: Props) => {
  return (
    <textarea 
      placeholder={placeholder}
      value={value}
      name={name}
      required={required}
      onChange={onChange}
      onBlur={onBlur}
      className={`inline-flex border rounded-2lg py-3 px-4 border-border bg-input text-text text-sm transition-transform hover:border-white/50 focus:border-white focus:ring-0 ${full ? "w-full" : ""}`}
    />
  );
}