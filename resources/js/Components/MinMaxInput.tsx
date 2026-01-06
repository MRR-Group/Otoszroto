import React from "react";
import { NumberInput } from "@/Components/NumberInput";

type Props = {
  min?: number;
  max?: number;
  float?: boolean;
  allowNegative?: boolean;
  full?: boolean,
  onChange?: (_range: { min?: number; max?: number }) => void;
};

export const MinMaxInput = ({min, max, onChange, float, allowNegative, full}: Props) => {
  const emit = (nextMin?: number, nextMax?: number) => {
    if (nextMin !== undefined && nextMax !== undefined && nextMin > nextMax) {
      onChange?.({ min: nextMax, max: nextMin });
    } else {
      onChange?.({ min: nextMin, max: nextMax });
    }
  };

  return (
    <div className={`flex gap-2 ${full ? "w-full" : ""}`}>
      <NumberInput
        value={min}
        float={float}
        allowNegative={allowNegative}
        placeholder="Min"
        full={full}
        onChange={(v) => emit(v, max ?? undefined)}
      />

      <NumberInput
        value={max}
        float={float}
        allowNegative={allowNegative}
        placeholder="Max"
        full={full}
        onChange={(v) => emit(min ?? undefined, v)}
      />
    </div>
  );
};
