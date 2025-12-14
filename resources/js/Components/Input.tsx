type Props = {
  value?: string, 
  placeholder?: string,
  password?: boolean,
  email?: boolean,
  onChange?: () => void,
}

export const Input = ({value, placeholder, password, email, onChange}: Props) => {
  return (
    <input 
      type={password ? "password" : email ? "email" : "text"}
      placeholder={placeholder}
      value={value}
      className="inline-flex border rounded-2lg py-3 px-4 border-border bg-input text-text text-sm transition-transform hover:border-white/50 focus:border-white focus:ring-0"
    />
  );
}