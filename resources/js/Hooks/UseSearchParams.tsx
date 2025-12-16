import { router, usePage } from "@inertiajs/react";
import { useCallback, useMemo, useRef, useState } from "react";

type Options = {
  replace?: boolean;
  preserveScroll?: boolean;
  only?: string[];
};

type SetParamsOptions = {
  replace?: boolean;
  only?: string[];
};

function parseSearch<T>(search: string): T {
  const params = new URLSearchParams(search);
  const out: Record<string, string> = {};

  params.forEach((value, key) => {
    out[key] = value;
  });

  return out as T;
}


function buildSearch<T>(params: T): T {
  const out: Record<string, any> = {};

  for (const [k, v] of Object.entries(params as Record<string, any>)) {
    if (v === undefined) {
      continue;
    }

    if (v === null) {
      continue;
    }

    if (v === "") {
      continue;
    }

    out[k] = v;
  }

  return out as T;
}

export function useSearchParams<T>(options: Options = {}) {
  const { replace = true, preserveScroll = true, only } = options;
  const page = usePage();
  const [isNavigating, setIsNavigating] = useState(false);
  const navigationRef = useRef(0);

  const params = useMemo(() => parseSearch<T>(page.url.split("?")[1] ?? ""), [page.url]);

  const setParams = useCallback((next: T, opts: SetParamsOptions = {}) => {
    const current = parseSearch<T>(page.url.split("?")[1] ?? "");
    const merged = { ...current, ...next };

    navigationRef.current += 1;
    const navId = navigationRef.current;

    setIsNavigating(true);

    router.get(
      page.url.split("?")[0],
      buildSearch(merged) as FormData,
      {
        replace: opts.replace ?? replace,
        preserveState: true,
        preserveScroll,
        only: opts.only ?? only,
        onFinish: () => {
          if (navigationRef.current === navId) {
            setIsNavigating(false);
          }
        },
      }
    );
  }, [page.url, replace, preserveScroll, only]);

  const patchParams = useCallback((patch: T, opts?: SetParamsOptions) => {
    setParams(patch, opts)
  }, [setParams]);

  const resetParams = useCallback(
    (opts?: SetParamsOptions) => {
      navigationRef.current += 1;
      const navId = navigationRef.current;

      setIsNavigating(true);

      router.get(
        page.url.split("?")[0],
        {},
        {
          replace: opts?.replace ?? replace,
          preserveState: true,
          preserveScroll,
          only: opts?.only ?? only,
          onFinish: () => {
            if (navigationRef.current === navId) {
              setIsNavigating(false);
            }
          },
        }
      );
    },
    [page.url, replace, preserveScroll, only]
  );

  return {
    params,
    isNavigating,
    setParams,
    patchParams,
    resetParams,
  };
}
