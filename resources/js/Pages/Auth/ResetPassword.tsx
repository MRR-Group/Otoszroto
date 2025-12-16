import React, { useMemo } from "react";
import { Form, useForm } from "@inertiajs/react";
import { Title } from "@/Components/Title";
import { Panel } from "@/Components/Panel";
import { Input } from "@/Components/Input";
import { Text } from "@/Components/Text";
import { NavButton } from "@/Components/Button";
import { ButtonPrimary } from "@/Components/ButtonPrimary";

type Props = {
  errors: Partial<{
    token: string;
    email: string;
    password: string;
    password_confirmation: string;
  }>;
};

export function ResetPassword({ errors }: Props) {
  const form = useForm({
    token: "",
    email: "",
    password: "",
    password_confirmation: "",
  });

  const passwordsMismatch = useMemo(() => {
    if (!form.data.password || !form.data.password_confirmation) {
        return false;
    }

    return form.data.password !== form.data.password_confirmation;
  }, [form.data.password, form.data.password_confirmation]);

  const submitDisabled = form.processing || passwordsMismatch;

  const submit = (e: React.MouseEvent) => {
    e.preventDefault();
    
    if (submitDisabled) {
        return;
    }
    
    form.post("/reset-password");
  };

  return (
    <div className="w-full md:max-w-10/12 p-4 mt-5 mx-auto">
      <Title type="h2">Reset hasła</Title>

      <Panel>
        <Form action="/reset-password" method="POST" className="flex flex-col gap-3">
          <div className="flex flex-col gap-2">
            <Text>Kod resetu</Text>

            <Input
              name="token"
              placeholder="XXXXXX"
              required
              value={form.data.token}
              onChange={(e) => {
                form.clearErrors("token");
                form.setData("token", e.target.value);
              }}
            />

            {(errors?.token || form.errors.token) && (
              <p className="text-danger text-sm">
                {errors?.token ?? form.errors.token}
              </p>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <Text>Email</Text>

            <Input
              name="email"
              placeholder="example@mail.com"
              required
              email
              value={form.data.email}
              onChange={(e) => {
                form.clearErrors("email");
                form.setData("email", e.target.value);
              }}
            />

            {(errors?.email || form.errors.email) && (
              <p className="text-danger text-sm">
                {errors?.email ?? form.errors.email}
              </p>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <Text>Nowe hasło</Text>

            <Input
              name="password"
              placeholder="*******"
              required
              password
              value={form.data.password}
              onChange={(e) => {
                form.clearErrors("password");
                form.setData("password", e.target.value);
              }}
            />

            {(errors?.password || form.errors.password) && (
              <p className="text-danger text-sm">
                {errors?.password ?? form.errors.password}
              </p>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <Text>Powtórz hasło</Text>

            <Input
              name="password_confirmation"
              placeholder="*******"
              required
              password
              value={form.data.password_confirmation}
              onChange={(e) => {
                form.clearErrors("password_confirmation");
                form.setData("password_confirmation", e.target.value);
              }}
            />

            {passwordsMismatch && (
              <p className="text-danger text-sm">Hasła muszą być takie same.</p>
            )}

            {!passwordsMismatch &&
              (errors?.password_confirmation ||
                form.errors.password_confirmation) && (
                <p className="text-danger text-sm">
                  {errors?.password_confirmation ??
                    form.errors.password_confirmation}
                </p>
              )}
          </div>

          <a href="/forgot-password" className="block">
            <Text className="text-sm" color="muted">
              Nie masz kodu resetu?
            </Text>
            <Text className="text-sm" color="primary">
              Wyślij ponownie
            </Text>
          </a>

          <div className="flex justify-end items-center">
            <div className="flex gap-2">
              <NavButton href="/login" text="Anuluj" disabled={form.processing} />
              <ButtonPrimary
                text="Zresetuj hasło"
                loading={form.processing}
                onClick={submit}
              />
            </div>
          </div>
        </Form>
      </Panel>
    </div>
  );
}
