"use client";

import { Button } from "@/components/ui/button";
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
} from "@/components/ui/navigation-menu";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { ModeToggle } from "@/views/components/ModeToggle";
import Link from "next/link";
import { useRouter } from "next/navigation";
import { useAppDispatch } from "@/store/hooks";
import { useSelector } from "react-redux";
import { RootState } from "@/store";
import { userLogout } from "@/store/auth/thunks";
import { UserPreferenceModal } from "@/views/modals/UserPreferenceModal";
import { Suspense } from "react";

// Navigation links array to be used in both desktop and mobile menus
const navigationLinks = [{ href: "/", label: "Home", active: true }];

export default function Navbar() {
    const router = useRouter();
    const dispatch = useAppDispatch();

    const { isAuthenticated, user } = useSelector((state: RootState) => state.auth);

    const handleLogout = () => {
        dispatch(userLogout()).then(() => {
            router.push("/");
        });
    };

    return (
        <header className="border-b px-4 md:px-6">
            <div className="flex h-16 items-center justify-between gap-4 mx-auto container">
                {/* Left side */}
                <div className="flex items-center gap-2">
                    {/* Mobile menu trigger */}
                    <Popover>
                        <PopoverTrigger asChild>
                            <Button className="group size-8 md:hidden" variant="ghost" size="icon">
                                <svg
                                    className="pointer-events-none"
                                    width={16}
                                    height={16}
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M4 12L20 12"
                                        className="origin-center -translate-y-[7px] transition-all duration-300 ease-[cubic-bezier(.5,.85,.25,1.1)] group-aria-expanded:translate-x-0 group-aria-expanded:translate-y-0 group-aria-expanded:rotate-[315deg]"
                                    />
                                    <path
                                        d="M4 12H20"
                                        className="origin-center transition-all duration-300 ease-[cubic-bezier(.5,.85,.25,1.8)] group-aria-expanded:rotate-45"
                                    />
                                    <path
                                        d="M4 12H20"
                                        className="origin-center translate-y-[7px] transition-all duration-300 ease-[cubic-bezier(.5,.85,.25,1.1)] group-aria-expanded:translate-y-0 group-aria-expanded:rotate-[135deg]"
                                    />
                                </svg>
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent align="start" className="w-36 p-1 md:hidden">
                            <NavigationMenu className="max-w-none *:w-full">
                                <NavigationMenuList className="flex-col items-start gap-0 md:gap-2">
                                    {navigationLinks.map((link, index) => (
                                        <NavigationMenuItem key={index} className="w-full">
                                            <NavigationMenuLink
                                                href={link.href}
                                                className="py-1.5"
                                                active={link.active}
                                            >
                                                {link.label}
                                            </NavigationMenuLink>
                                        </NavigationMenuItem>
                                    ))}
                                </NavigationMenuList>
                            </NavigationMenu>
                        </PopoverContent>
                    </Popover>
                    {/* Main nav */}
                    <div className="flex items-center gap-6">
                        <a href="#" className="text-primary hover:text-primary/90 font-bold">
                            📰 News Aggregator
                        </a>
                        {/* Navigation menu */}
                        <NavigationMenu className="max-md:hidden">
                            <NavigationMenuList className="gap-2">
                                {navigationLinks.map((link, index) => (
                                    <NavigationMenuItem key={index}>
                                        <NavigationMenuLink
                                            active={link.active}
                                            href={link.href}
                                            className="text-muted-foreground hover:text-primary py-1.5 font-medium"
                                        >
                                            {link.label}
                                        </NavigationMenuLink>
                                    </NavigationMenuItem>
                                ))}
                            </NavigationMenuList>
                        </NavigationMenu>
                    </div>
                </div>
                {/* Right side */}
                <Suspense fallback={<div>Loading pagination...</div>}>
                    <div className="flex items-center gap-2">
                        {isAuthenticated && (
                            <>
                                <Button asChild variant="ghost" size="sm" className="text-sm">
                                    <span className="cursor-pointer" onClick={handleLogout}>
                                        Logout
                                    </span>
                                </Button>
                                <UserPreferenceModal />
                            </>
                        )}

                        {!isAuthenticated && (
                            <>
                                <Button asChild variant="ghost" size="sm" className="text-sm">
                                    <Link href="/login">Sign In</Link>
                                </Button>
                                <Button asChild size="sm" className="text-sm">
                                    <Link href="/register">Get Started</Link>
                                </Button>
                            </>
                        )}

                        <ModeToggle />
                    </div>
                </Suspense>
            </div>
        </header>
    );
}
