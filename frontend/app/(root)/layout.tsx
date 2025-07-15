"use client";

import Navbar from "@/views/components/Navbar";
import React, { useEffect } from "react";
import ScreenLoader from "@/views/components/ScreenLoader";
import { useAppDispatch } from "@/store/hooks";
import { hydrateAuthFromStorage } from "@/store/auth/slice";

export default function Layout({ children }: Readonly<{ children: React.ReactNode }>) {
    const dispatch = useAppDispatch();

    useEffect(() => {
        const userJson = localStorage.getItem("user");
        if (userJson) {
            const user = JSON.parse(userJson);
            dispatch(
                hydrateAuthFromStorage({
                    user,
                    isAuthenticated: true,
                    loading: false,
                })
            );
        }
    }, [dispatch]);

    return (
        <div className="flex flex-col min-h-screen">
            <ScreenLoader />
            <Navbar />
            <main className="flex-grow">{children}</main>
        </div>
    );
}
