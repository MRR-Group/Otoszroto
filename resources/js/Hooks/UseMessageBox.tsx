import { createContext, useContext } from "react";

type ConfirmOptions = {
  title: string;
  message?: string;
  confirmText?: string;
  cancelText?: string;
  danger?: boolean;
};

type MessageBoxContextType = {
  confirm: (_options: ConfirmOptions) => Promise<boolean>;
};

export const MessageBoxContext = createContext<MessageBoxContextType | null>(null);

export const useMessageBox = () => {
  const ctx = useContext(MessageBoxContext);
  
  if (!ctx) {
    throw new Error("useMessageBox must be used inside MessageBoxProvider");
  }

  return ctx;
};
