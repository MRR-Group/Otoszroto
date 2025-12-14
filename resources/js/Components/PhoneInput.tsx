import React from "react";

type Props = {
  value?: string;
  name?: string;
  placeholder?: string;
  required?: boolean;
  onChange?: (_value: string) => void;
};

function formatPhone(value: string): string {
  if (!value) {
    return "+";
  }

  const digits = value.replace(/\D/g, "");

  const parts = [
    digits.slice(0, 2),
    digits.slice(2, 5),
    digits.slice(5, 8),
    digits.slice(8, 11),
  ].filter(Boolean);

  return "+" + parts.join(" ");
}

export const PhoneInput = ({
  value = "",
  name,
  placeholder = "+48 123 456 789",
  required,
  onChange,
}: Props) => {
  const displayValue = formatPhone(value);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const raw = e.target.value;

    const digits = raw.replace(/\D/g, "");

    onChange?.(digits);
  };

  return (
    <input
      className="inline-flex border rounded-2lg py-3 px-4 border-border bg-input text-text text-sm transition-transform hover:border-white/50 focus:border-white focus:ring-0"
      type="tel"
      name={name}
      placeholder={placeholder}
      required={required}
      value={displayValue}
      onChange={handleChange}
      inputMode="numeric"
      autoComplete="tel"
    />
  );
};
