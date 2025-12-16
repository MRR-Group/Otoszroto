import { useEffect, useMemo, useRef, useState } from "react";

type Props<T, V extends string | number> = {
  items: T[];
  selected: V | undefined;
  onChange: (_value: V) => void;
  item?: (_item: T) => { value: V; text: string };
  placeholder?: string;
  clearable?: boolean,
  onClear?: () => void,
};

function defaultItem<T extends { toString(): string }>(item: T) {
  const s = item.toString();

  return { value: s, text: s };
}

const defaultItemMapper = <T, V extends string | number>(it: T) =>
  defaultItem(it as any) as { value: V; text: string };

export const Select = <T, V extends string | number>({ items, selected, onChange, item = defaultItemMapper, placeholder = "Wybierz", clearable, onClear}: Props<T, V>) => {
  const [open, setOpen] = useState(false);
  const ref = useRef<HTMLDivElement>(null);

  const options = useMemo(() => items.map((i) => item(i)), [items, item]);
  const selectedOption = options.find((o) => o.value === selected);

  useEffect(() => {
    const handler = (e: MouseEvent) => {
      if (!ref.current?.contains(e.target as Node)) setOpen(false);
    };
    document.addEventListener("mousedown", handler);
    return () => document.removeEventListener("mousedown", handler);
  }, []);

  return (
    <div ref={ref} className="relative inline-block">
      <button
        type="button"
        onClick={() => setOpen((v) => !v)}
        className="
          flex w-full items-center justify-between
          rounded-2lg border border-border
          bg-input px-4 py-3 text-sm text-text
          transition-colors hover:border-white/50
          focus:outline-none focus:ring-0 focus:border-white
        "
      >
        <span className="truncate">
          {selectedOption?.text ?? placeholder}
        </span>

        <svg
          className={`h-4 w-4 transition ${open ? "rotate-180" : ""}`}
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fillRule="evenodd"
            d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.19l3.71-3.96a.75.75 0 1 1 1.08 1.04l-4.25 4.53a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06z"
            clipRule="evenodd"
          />
        </svg>
      </button>

      {open && (
        <div
          className="
            absolute z-50 mt-2 w-full
            rounded-2xl border border-border
            bg-panel shadow-xl
            overflow-hidden
          "
        >
          {clearable && (
            <button 
              type="button" 
              onClick={() => { onClear?.(), setOpen(false) }}
              className={[
                "flex w-full px-4 py-2.5 text-sm text-left transition",
                !selected
                  ? "bg-white/10 text-text font-semibold"
                  : "text-text hover:bg-white/5",
              ].join(" ")}
            >
              {placeholder}
            </button>
          )}

          {options.map((opt) => {
            const active = opt.value === selected;

            return (
              <button
                key={String(opt.value)}
                type="button"
                onClick={() => {
                  onChange(opt.value);
                  setOpen(false);
                }}
                className={[
                  "flex w-full px-4 py-2.5 text-sm text-left transition",
                  active
                    ? "bg-white/10 text-text font-semibold"
                    : "text-text hover:bg-white/5",
                ].join(" ")}
              >
                {opt.text}
              </button>
            );
          })}
        </div>
      )}
    </div>
  );
};
