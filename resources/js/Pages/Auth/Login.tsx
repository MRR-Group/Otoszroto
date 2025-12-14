import React from 'react';
import { Form, useForm } from "@inertiajs/react";
import { Title } from '@/Components/Title';
import { Panel } from '@/Components/Panel';
import { Input } from '@/Components/Input';
import { Text } from '@/Components/Text';
import { Button, NavButton } from '@/Components/Button';
import { AsyncButtonPrimary, ButtonPrimary } from '@/Components/ButtonPrimary';

type Props = {
  errors: {
    email: string,
    password: string,
  };
}

export function Login({ errors }: Props) {
  const form = useForm({
    email: "",
    password: "",
  });

  const submit = (e: React.MouseEvent) => {
    e.preventDefault();
    form.post("/login");
  };

  return (
    <div className='w-full md:max-w-10/12 p-4 mt-5 mx-auto'>
      <Title type='h2'>Logowanie</Title>

      <Panel>
        <Form
          action="/login"
          method="POST"
          className='flex flex-col gap-3'
        >
          <div className='flex flex-col gap-2'>
            <Text>Email</Text>

            <Input 
              name="email"
              placeholder="example@mail.com" 
              required 
              email 
              value={form.data.email} 
              onChange={(e)=> form.setData("email", e.target.value)} 
            />
            
            {(errors?.email || form.errors.email) && (
              <p className="text-danger text-sm">{errors?.email ?? form.errors.email}</p>
            )}
          </div>

          <a href='/forgot-password' className='block'>
            <Text className='text-sm' color='muted'>Nie masz konta?</Text>
            <Text className='text-sm' color='primary'>Zarejestruj się</Text>
          </a>

          <div className='flex flex-col gap-2'>
            <Text>Hasło</Text>

            <Input 
              name="password" 
              placeholder="*******" 
              required
              password
              value={form.data.password} 
              onChange={(e)=> form.setData("password", e.target.value)} 
            />

            {(errors?.password || form.errors.password) && (
              <p className="text-danger text-sm">{errors?.password ?? form.errors.password}</p>
            )}
          </div>

          <a href='/forgot-password' className='block'>
            <Text className='text-sm' color='muted'>Nie pamiętasz hasła?</Text>
            <Text className='text-sm' color='primary'>Przywróć je</Text>
          </a>

          <div className='flex justify-end items-center'>
            <div className='flex gap-2'>
              <NavButton href='/' text='Anuluj' disabled={form.processing} />
              <ButtonPrimary text='Zaloguj się' loading={form.processing} onClick={submit} />
            </div>
          </div>
        </Form>
      </Panel>
    </div>
  );
}
