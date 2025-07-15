import Navbar from "@/views/components/Navbar";
import React from "react";
import ScreenLoader from "@/views/components/ScreenLoader";

export default function Layout({ children }: Readonly<{ children: React.ReactNode }>) {
    return (
        <div className="flex flex-col min-h-screen">
            <ScreenLoader />
            <Navbar />
            <main className="flex-grow">{children}</main>
        </div>
    );
}
