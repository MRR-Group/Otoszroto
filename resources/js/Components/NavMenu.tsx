import { MouseEventHandler, PropsWithChildren, useEffect, useId, useRef, useState } from "react";

type Props = PropsWithChildren<{ 
  className?: string 
}>;

export function NavMenu({ children, className = "" }: Props) {
  const [open, setOpen] = useState(false);
  const panelRef = useRef<HTMLDivElement | null>(null);
  const buttonRef = useRef<HTMLButtonElement | null>(null);
  const btnId = useId();

  useEffect(() => {
    const onDoc = (e: MouseEvent) => {
      if (!open) {
        return;
      }

      const el = e.target as Node | null;
      
      if (!el) {
        return;
      }

      if (panelRef.current?.contains(el)) {
        return;
      }

      if (buttonRef.current?.contains(el)) {
        return;
      }

      setOpen(false);
    };

    document.addEventListener("mousedown", onDoc);
    return () => document.removeEventListener("mousedown", onDoc);
  }, [open]);

  const onClickInside: MouseEventHandler<HTMLDivElement> = (e) => {
    const target = e.target as HTMLElement | null;
    
    if (!target) {
      return;
    }

    const clickable = target.closest("a,button,[role='menuitem']");
    
    if (clickable) {
      setOpen(false);
    }
  };

  return (
    <div className={`relative ${className}`}>
      <button
        ref={buttonRef}
        type="button"
        aria-controls={btnId}
        aria-expanded={open}
        className="inline-flex items-center justify-center border border-border rounded-2lg px-3 py-3 w-10 h-10 bg-panel text-text hover:border-white/60 active:border-white transition-colors"
        onClick={() => setOpen(v => !v)}
      >
        <span className="sr-only">Menu</span>
        <div className="flex flex-col gap-1">
          <span className="block h-0.5 w-5 bg-text" />
          <span className="block h-0.5 w-5 bg-text" />
          <span className="block h-0.5 w-5 bg-text" />
        </div>
      </button>

      {open && (
        <div
          id={btnId}
          ref={panelRef}
          onClick={onClickInside}
          className="absolute right-0 top-12 z-50 w-64 border border-border rounded-2lg bg-panel shadow-lg p-2"
          role="menu"
        >
          <div className="flex flex-col gap-2">{children}</div>
        </div>
      )}
    </div>
  );
}
