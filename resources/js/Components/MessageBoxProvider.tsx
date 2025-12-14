import { ConfirmOptions, MessageBoxContext } from "@/Hooks/UseMessageBox";
import { PropsWithChildren, useState } from "react";
import { createPortal } from "react-dom";
import { Button } from "./Button";
import { Title } from "./Title";

type State = {
  open: boolean;
  options?: ConfirmOptions;
  resolve?: (_value: boolean) => void;
};

type Props = PropsWithChildren

export function MessageBoxProvider({ children }: Props) {
  const [state, setState] = useState<State>({ open: false, options: undefined });

  const confirm = (options: any) =>
    new Promise<boolean>((resolve) => {
      setState({ open: true, options, resolve });
    });

  const close = (result: boolean) => {
    state.resolve?.(result);
    setState({ open: false, options: undefined });
  };

  return (
    <MessageBoxContext.Provider value={{ confirm }}>
      {children}

      {state.open &&
        createPortal(
          <div className="fixed inset-0 z-50 flex items-center justify-center">
            <div
              className="absolute inset-0 bg-black/60"
              onClick={() => close(false)}
            />

            <div className="relative w-[90vw] max-w-md rounded-2xl border border-border bg-panel shadow-xl">
              <div className="px-5 py-4">
                <Title type="h3">
                  {state.options?.title}
                </Title>
              </div>

              {state.options?.message && (
                <div className="px-5 py-4 text-sm text-muted">
                  {state.options.message}
                </div>
              )}

              <div className="flex justify-end gap-3 px-5 py-4">
                <Button
                  onClick={() => close(false)}
                  text={state.options?.cancelText ?? "Anuluj"}
                />

                <Button
                  text={state.options?.confirmText ?? "OK"}
                  onClick={() => close(true)}
                  color={state.options?.danger ? "danger" : "ok"}
                />
              </div>
            </div>
          </div>,
          document.body
        )}
    </MessageBoxContext.Provider>
  );
}
