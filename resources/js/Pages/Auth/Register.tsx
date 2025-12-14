import React, { useMemo } from "react";
import { Form, useForm } from "@inertiajs/react";
import { Title } from "@/Components/Title";
import { Panel } from "@/Components/Panel";
import { Input } from "@/Components/Input";
import { Text } from "@/Components/Text";
import { NavButton } from "@/Components/Button";
import { ButtonPrimary } from "@/Components/ButtonPrimary";
import { PhoneInput } from "@/Components/PhoneInput";

type Props = {
  errors: Partial<{
    firstname: string;
    surname: string;
    phone: string;
    email: string;
    password: string;
    password_confirmation: string;
  }>;
};

export function Register({ errors }: Props) {
  const form = useForm({
    firstname: "",
    surname: "",
    phone: "",
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

    form.post("/register");
  };

  return (
    <div className="w-full md:max-w-10/12 p-4 mt-5 mx-auto">
      <Title type="h2">Rejestracja</Title>

      <Panel>
        <Form action="/register" method="POST" className="flex flex-col gap-3">
          <div className="flex flex-col gap-2">
            <Text>Imię</Text>
            <Input
              name="firstname"
              placeholder="Jan"
              required
              value={form.data.firstname}
              onChange={(e) => {
                form.clearErrors("firstname");
                form.setData("firstname", e.target.value);
              }}
            />
            {(errors?.firstname || form.errors.firstname) && (
              <p className="text-danger text-sm">
                {errors?.firstname ?? form.errors.firstname}
              </p>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <Text>Nazwisko</Text>
            <Input
              name="surname"
              placeholder="Kowalski"
              required
              value={form.data.surname}
              onChange={(e) => {
                form.clearErrors("surname");
                form.setData("surname", e.target.value);
              }}
            />
            {(errors?.surname || form.errors.surname) && (
              <p className="text-danger text-sm">
                {errors?.surname ?? form.errors.surname}
              </p>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <Text>Numer telefonu</Text>
            <PhoneInput
              name="phone"
              placeholder="+48 123 456 789"
              required
              value={form.data.phone}
              onChange={(value) => {
                form.clearErrors("phone");
                form.setData("phone", value);
              }}
            />
            {(errors?.phone || form.errors.phone) && (
              <p className="text-danger text-sm">
                {errors?.phone ?? form.errors.phone}
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
            <Text>Hasło</Text>
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

            {!passwordsMismatch && (errors?.password_confirmation || form.errors.password_confirmation) && (
              <p className="text-danger text-sm">
                {errors?.password_confirmation ?? form.errors.password_confirmation}
              </p>
            )}
          </div>

          <a href="/login" className="block">
            <Text className="text-sm" color="muted">
              Masz już konto?
            </Text>
            <Text className="text-sm" color="primary">
              Zaloguj się
            </Text>
          </a>

          <div className="flex justify-end items-center">
            <div className="flex gap-2">
              <NavButton href="/" text="Anuluj" disabled={form.processing} />
              <ButtonPrimary
                text="Zarejestruj się"
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
