import { type User } from "@/Types/user";
import { Text } from "../Text";
import { NavButton } from "../Button";
import { NavButtonPrimary, FormButtonPrimary } from "../ButtonPrimary";
import { NavMenu } from "../NavMenu";
import icon from "@/Assets/icon-small.png";

type Props = {
   user?: User
};

export function Navbar({ user }: Props) {
  const isLoggedIn = !!user;

  return (
    <div className="flex items-center border-b border-border p-2 gap-2">
      <a href="/" className="flex items-center gap-2">
        <img src={icon} className="h-10 object-contain" />
        <Text bold>OTOSZROTO</Text>
      </a>

      <div className="ml-auto">
        <div className="md:flex hidden gap-2">
          <NavButton href="/parts" text="Przeglądaj" />
          {isLoggedIn && <NavButton href="/parts/create" text="Wystaw część" />}
          {isLoggedIn && <NavButton href="/seller" text="Panel sprzedawcy" />}
          {!isLoggedIn && <NavButtonPrimary href="/login" text="Zaloguj" />}
          {isLoggedIn && <FormButtonPrimary url="/logout" text="Wyloguj" />}
        </div>

        <NavMenu className="md:hidden">
          <NavButton href="/parts" full text="Przeglądaj" />
          {isLoggedIn && <NavButton href="/parts/create" full text="Wystaw część" />}
          {isLoggedIn && <NavButton href="/seller" full text="Panel sprzedawcy" />}
          {!isLoggedIn && <NavButtonPrimary href="/login" full text="Zaloguj" />}
          {isLoggedIn && <FormButtonPrimary url="/logout" full text="Wyloguj" />}
        </NavMenu>
      </div>
    </div>
  );
}
