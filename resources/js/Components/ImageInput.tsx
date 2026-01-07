import React, { useEffect, useMemo, useRef, useState } from "react";

type ImageValue = File | string | null | undefined;

type Props = {
  value?: ImageValue;
  defaultValue?: string;
  onChange?: (_value: File | null) => void;
  name?: string;
  required?: boolean;
  full?: boolean;
  accept?: string;
  maxSizeBytes?: number;
  disabled?: boolean;
  label?: string;
  helperText?: string;
  error?: string;
};

function isProbablyUrlOrData(v: string): boolean {
  return v.startsWith("http://") || v.startsWith("https://") || v.startsWith("data:");
}

export const ImageInput = ({
  value,
  defaultValue,
  onChange,
  name,
  full,
  accept = "image/png",
  maxSizeBytes,
  disabled,
  helperText = "Przeciągnij i upuść albo kliknij, aby wybrać plik.",
  error,
}: Props) => {
  const inputRef = useRef<HTMLInputElement | null>(null);

  const [objectUrl, setObjectUrl] = useState<string | null>(null);
  const [dragOver, setDragOver] = useState(false);

  const previewSrc = useMemo(() => {

    if (value instanceof File) {
      return objectUrl;
    }
    
    if (typeof value === "string" && value) {
      return value;
    }

    if (value === null) {
      return null;
    }

    if (defaultValue && isProbablyUrlOrData(defaultValue)) {
      return defaultValue;
    }

    return null;
  }, [value, defaultValue, objectUrl]);

  useEffect(() => {
    if (value instanceof File) {
      const url = URL.createObjectURL(value);
      
      // This effect intentionally derives a preview URL from the `value` File.
      // The state update is required to store a temporary object URL used
      // for local image preview and does not introduce a render loop.
      //
      // The object URL is revoked in the cleanup function to prevent
      // memory leaks when the file changes or the component unmounts.
      //
      // eslint-disable-next-line react-hooks/set-state-in-effect
      setObjectUrl(url);

      return () => URL.revokeObjectURL(url);
    }

    setObjectUrl(null);

    return;
  }, [value]);

  const openDialog = () => {
    if (!disabled) {
      inputRef.current?.click();
    }
  };

  const clear = (e?: React.MouseEvent) => {
    e?.preventDefault();
    e?.stopPropagation();

    if (disabled) {
      return;
    }

    if (inputRef.current) {
      inputRef.current.value = "";
    }
    
    onChange?.(null);
  };

  const validateAndSet = (file: File | undefined | null) => {
    if (!file) {
      return;
    }

    if (!file.type.startsWith("image/")) {
      return;
    }

    if (maxSizeBytes && file.size > maxSizeBytes) {
      return;
    }

    onChange?.(file);
  };

  const handleFileInput = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0] ?? null;

    validateAndSet(file);
  };

  const onDrop = (e: React.DragEvent) => {
    e.preventDefault();
    e.stopPropagation();

    if (disabled) {
      return;
    }

    setDragOver(false);

    const file = e.dataTransfer.files?.[0] ?? null;

    validateAndSet(file);
  };

  const onDragEnter = (e: React.DragEvent) => {
    e.preventDefault();
    e.stopPropagation();

    if (disabled) {
      return;
    }

    setDragOver(true);
  };

  const onDragOver = (e: React.DragEvent) => {
    e.preventDefault();
    e.stopPropagation();

    if (disabled) {
      return;
    }

    setDragOver(true);
  };

  const onDragLeave = (e: React.DragEvent) => {
    e.preventDefault();
    e.stopPropagation();

    if (disabled) {
      return;
    }

    setDragOver(false);
  };

  return (
    <div className={`flex flex-col gap-2 ${full ? "w-full" : ""}`}>
      <div className="flex items-center gap-2">
        {previewSrc && (
          <button
            type="button"
            onClick={clear}
            disabled={disabled}
            className="text-sm px-3 py-1 rounded-2lg border border-border bg-input text-text hover:border-white/50 disabled:opacity-60"
          >
            Usuń
          </button>
        )}
      </div>

      <div
        role="button"
        tabIndex={0}
        onClick={openDialog}
        onKeyDown={(e) => {
          if (e.key === "Enter" || e.key === " ") {
            openDialog();
          }
        }}
        onDrop={onDrop}
        onDragEnter={onDragEnter}
        onDragOver={onDragOver}
        onDragLeave={onDragLeave}
        className={[
          "relative cursor-pointer select-none",
          "border border-dashed rounded-2lg",
          "bg-input text-text",
          "transition-transform hover:border-white/50 focus:ring-0",
          "p-4",
          disabled ? "opacity-60 cursor-not-allowed" : "",
          dragOver ? "border-white/70" : "border-border",
          error ? "border-danger" : "",
        ].join(" ")}
      >
        <input
          ref={inputRef}
          type="file"
          name={name}
          accept={accept}
          disabled={disabled}
          onChange={handleFileInput}
          className="hidden"
        />

        {!previewSrc ? (
          <div className="flex flex-col items-center justify-center gap-2 text-center">
            <div className="text-sm">{helperText}</div>
            <div className="text-xs opacity-80">
              {accept.replaceAll("image/", "• ")}
              {maxSizeBytes ? ` • max ${(maxSizeBytes / 1024 / 1024).toFixed(1)}MB` : ""}
            </div>
          </div>
        ) : (
          <div className="flex flex-col gap-3">
            <div className="w-full overflow-hidden rounded-2lg border border-border bg-black/10">
              <img
                src={previewSrc}
                alt="Podgląd zdjęcia"
                className="w-full h-56 object-cover"
                draggable={false}
              />
            </div>

            <div className="flex items-center justify-between gap-2">
              <div className="text-xs opacity-80">
                Kliknij, aby zmienić • albo przeciągnij nowy plik
              </div>

              <button
                type="button"
                onClick={(e) => {
                  e.preventDefault();
                  e.stopPropagation();
                  openDialog();
                }}
                disabled={disabled}
                className="text-sm px-3 py-1 rounded-2lg border border-border bg-input text-text hover:border-white/50 disabled:opacity-60"
              >
                Zmień
              </button>
            </div>
          </div>
        )}
      </div>

      {error && <p className="text-danger text-sm">{error}</p>}
    </div>
  );
};
