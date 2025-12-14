import React from "react";
import { Form, useForm } from "@inertiajs/react";
import { Title } from "@/Components/Title";
import { Panel } from "@/Components/Panel";
import { Input } from "@/Components/Input";
import { Text } from "@/Components/Text";
import { NavButton } from "@/Components/Button";
import { ButtonPrimary } from "@/Components/ButtonPrimary";

type Props = {
  errors: Partial<{
    email: string;
  }>;
};

export function ForgotPassword({ errors }: Props) {
  const form = useForm({
    email: "",
  });

  const submit = (e: React.MouseEvent) => {
    e.preventDefault();
    form.post("/forgot-password");
  };

  return (
    <div className="w-full md:max-w-10/12 p-4 mt-5 mx-auto">
      <Title type="h2">Reset hasła</Title>

      <Panel>
        <Form action="/forgot-password" method="POST" className="flex flex-col gap-3">
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
              <p className="text-danger text-sm">{errors?.email ?? form.errors.email}</p>
            )}
          </div>

          <a href="/reset-password" className="block">
            <Text className="text-sm" color="muted">
              Masz już kod resetu?
            </Text>
            <Text className="text-sm" color="primary">
              Ustaw nowe hasło
            </Text>
          </a>

          <div className="flex justify-end items-center">
            <div className="flex gap-2">
              <NavButton href="/login" text="Anuluj" disabled={form.processing} />
              <ButtonPrimary
                text="Wyślij kod"
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
