import React from "react";

type Props = {
  value?: string, 
  name?: string,
  placeholder?: string,
  password?: boolean,
  email?: boolean,
  required?: boolean,
  onChange?: (e: React.ChangeEvent<HTMLInputElement>) => void,
}

export const Input = ({value, name, placeholder, password, email, required, onChange}: Props) => {
  return (
    <input 
      type={password ? "password" : email ? "email" : "text"}
      placeholder={placeholder}
      value={value}
      name={name}
      required={required}
      onChange={onChange}
      className="inline-flex border rounded-2lg py-3 px-4 border-border bg-input text-text text-sm transition-transform hover:border-white/50 focus:border-white focus:ring-0"
    />
  );
}