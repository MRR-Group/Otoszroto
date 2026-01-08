import React, { useEffect, useMemo, useRef, useState } from "react";
import { type Flash } from "@/Types/flash";

type Props = {
  errors?: {
    message?: string;
  };
  flash?: Flash;
  autoHideMs?: number;
};

type Notice = {
  id: string;
  variant: "error" | "success";
  title: string;
  message: string;
};

function makeId() {
  return `${Date.now()}-${Math.random().toString(16).slice(2)}`;
}

export function Notification({ errors, flash, autoHideMs = 5000 }: Props) {
  const notice: Notice | null = useMemo(() => {
    const err = errors?.message?.trim();
    const flashErr = (flash as any)?.error?.trim?.() ?? (flash as any)?.error;
    const flashMsg = (flash as any)?.message?.trim?.() ?? (flash as any)?.message;

    if (err) {
      return { id: makeId(), variant: "error", title: "Błąd", message: err };
    }
    if (flashErr) {
      return { id: makeId(), variant: "error", title: "Błąd", message: String(flashErr) };
    }
    if (flashMsg) {
      return { id: makeId(), variant: "success", title: "Sukces", message: String(flashMsg) };
    }
    return null;
  }, [errors?.message, flash]);

  const [current, setCurrent] = useState<Notice | null>(null);
  const [visible, setVisible] = useState(false);

  const closeTimeoutRef = useRef<number | null>(null);
  const removeTimeoutRef = useRef<number | null>(null);

  const clearTimers = () => {
    if (closeTimeoutRef.current) {
      window.clearTimeout(closeTimeoutRef.current);
    }

    if (removeTimeoutRef.current) {
      window.clearTimeout(removeTimeoutRef.current);
    }

    closeTimeoutRef.current = null;
    removeTimeoutRef.current = null;
  };

  const startAutoHide = () => {
    clearTimers();

    closeTimeoutRef.current = window.setTimeout(() => {
      setVisible(false);

      removeTimeoutRef.current = window.setTimeout(() => {
        setCurrent(null);
      }, 250);
    }, autoHideMs);
  };

  const dismiss = () => {
    clearTimers();
    setVisible(false);
    removeTimeoutRef.current = window.setTimeout(() => setCurrent(null), 250);
  };

  useEffect(() => {
    if (!notice) {
      return;
    }

    setCurrent((prev) => {
      if (prev?.variant === notice.variant && prev?.message === notice.message) {
        return prev;
      }

      return notice;
    });

    setVisible(true);
    startAutoHide();

    return () => clearTimers();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [notice?.id]);

  useEffect(() => {
    if (!current) {
      return;
    }

    if (visible) {
      startAutoHide();
    }

    return () => clearTimers();
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [current?.id]);

  if (!current) return null;

  const styles =
    current.variant === "success"
      ? {
        ring: "ring-ok/20",
        border: "border-ok/30",
        badge: "bg-ok/15 text-ok border border-ok/25",
        bar: "bg-ok",
      }
      : {
        ring: "ring-danger/20",
        border: "border-danger/30",
        badge: "bg-danger/15 text-danger border border-danger/25",
        bar: "bg-danger",
      };

  return (
    <div className="fixed z-[9999] top-4 right-4 left-4 sm:left-auto sm:w-[420px]">
      <div
        className={[
          "relative overflow-hidden",
          "rounded-2xl border bg-gradient-to-b from-[#12161b] to-[#0f141a]",
          "shadow-xl backdrop-blur",
          "ring-1",
          styles.border,
          styles.ring,
          "transition-all duration-200 ease-out",
          visible ? "opacity-100 translate-y-0" : "opacity-0 -translate-y-2 pointer-events-none",
        ].join(" ")}
        role="status"
        aria-live="polite"
      >
        <div
          className={[
            "absolute left-0 top-0 h-[3px] w-full opacity-80",
            styles.bar,
            visible ? "animate-[toast-progress_var(--toast-ms)_linear_forwards]" : "",
          ].join(" ")}
          style={{ ["--toast-ms" as any]: `${autoHideMs}ms` }}
        />

        <div className="p-4">
          <div className="flex items-start gap-3">
            <span className={`shrink-0 rounded-full px-2.5 py-1 text-xs font-extrabold ${styles.badge}`}>
              {current.variant === "success" ? "OK" : "ERR"}
            </span>

            <div className="min-w-0 flex-1">
              <div className="flex items-start justify-between gap-3">
                <div className="min-w-0">
                  <p className="text-sm font-extrabold text-text">{current.title}</p>
                  <p className="mt-1 text-sm text-muted break-words">{current.message}</p>
                </div>

                <button
                  type="button"
                  onClick={dismiss}
                  className={[
                    "shrink-0",
                    "inline-flex items-center justify-center",
                    "h-8 w-8 rounded-2lg border border-border",
                    "bg-input text-muted",
                    "transition hover:border-white/20 hover:text-text active:scale-105",
                  ].join(" ")}
                  aria-label="Zamknij"
                  title="Zamknij"
                >
                  <svg viewBox="0 0 20 20" className="h-4 w-4" fill="currentColor">
                    <path
                      fillRule="evenodd"
                      d="M4.47 4.47a.75.75 0 0 1 1.06 0L10 8.94l4.47-4.47a.75.75 0 1 1 1.06 1.06L11.06 10l4.47 4.47a.75.75 0 0 1-1.06 1.06L10 11.06l-4.47 4.47a.75.75 0 0 1-1.06-1.06L8.94 10 4.47 5.53a.75.75 0 0 1 0-1.06z"
                      clipRule="evenodd"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
