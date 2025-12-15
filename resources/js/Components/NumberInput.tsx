import React, { useEffect, useState } from "react";
import { Input } from "@/Components/Input";

type Props = {
  value?: number;
  onChange?: (_value?: number) => void;
  float?: boolean;
  allowNegative?: boolean;
  placeholder?: string;
  name?: string;
  full?: boolean,
};

export const NumberInput = ({ value, onChange, float = false, allowNegative = true, placeholder, full, name }: Props) => {
  const [raw, setRaw] = useState<string>("");

  useEffect(() => {
    if (value === null || value === undefined) {
      // This effect intentionally synchronizes local input state with external value.
      // The warning is suppressed because this state is derived from props and updated
      // only when the controlled value changes, not on every render.
      //
      // eslint-disable-next-line react-hooks/set-state-in-effect
      setRaw("");
    } else {
      setRaw(String(value));
    }
  }, [value]);

  const normalize = (v: string) => v.replace(",", ".");

  const isValidRaw = (v: string) => {
    if (v === "" || v === "-" || v === "." || v === "-.") {
      return true;
    }

    const n = Number(normalize(v));
    
    if (Number.isNaN(n)) {
      return false;
    }

    if (!allowNegative && n < 0) {
      return false;
    }

    if (!float && !Number.isInteger(n)) {
      return false;
    }

    return true;
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const v = e.target.value;

    if (!/^[0-9.,-]*$/.test(v)) {
      return;
    }
    
    if (!isValidRaw(v)) {
      return;
    }

    setRaw(v);
  };

  const handleBlur = () => {
    if (raw === "" || raw === "-" || raw === "." || raw === "-.") {
      onChange?.(undefined);
      setRaw("");

      return;
    }

    const parsed = Number(normalize(raw));

    if (Number.isNaN(parsed)) {
      setRaw("");
      onChange?.(undefined);

      return;
    }

    const final = float ? parsed : Math.trunc(parsed);

    setRaw(String(final));
    onChange?.(final);
  };

  return (
    <Input
      name={name}
      placeholder={placeholder}
      value={raw}
      full={full}
      onChange={handleChange}
      onBlur={handleBlur}
    />
  );
};
