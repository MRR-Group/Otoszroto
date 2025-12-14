import React from "react";
import { withAsyncButton } from "./WithAsyncButton";

type FormButtonExtraProps = {
  url: string,
  method?: "GET" | "POST" | "PUT" | "PATCH" | "DELETE",
  data?: Record<string, any>,
  followRedirect?: boolean,
  disabled?: boolean,
  onResponse?: (res: Response) => Promise<void> | void,
};

function getCsrfToken(): string | null {
  return document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") ?? null;
}

export function withFormButton<P>(
  Visual: React.ComponentType<P>
) {
 return function FromButton(props: P & FormButtonExtraProps) {
    const { url, method="POST", data, followRedirect=true, onResponse, disabled, ...rest } = props;
    const AsyncVisual = withAsyncButton<P>(Visual);

    const sendForm = async () => {
      const fd = new FormData();

      if (data) {
        for (const [k, v] of Object.entries(data)) {
          fd.append(k, String(v));
        }
      }

      const csrf = getCsrfToken();

      const res = await fetch(url, {
        method,
        credentials: "same-origin",
        headers: {
          ...(csrf ? { "X-CSRF-TOKEN": csrf } : {}),
          "X-Requested-With": "XMLHttpRequest",
        },
        body: method === "GET" ? undefined : fd,
        redirect: "follow",
      });

      await onResponse?.(res);

      if (followRedirect && res.redirected) {
        window.location.href = res.url;
        return;
      }

      if (!res.ok) {
        throw new Error(`Request failed: ${res.status}`);
      }
    }

    return (
      <AsyncVisual
        {...(rest as P)}
        disabled={disabled}
        asyncAction={sendForm}
      />
    );
  };
}
