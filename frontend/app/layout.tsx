import type { Metadata } from "next";
import { Geist, Geist_Mono } from "next/font/google";
import React from "react";
import "./globals.css";
import ReduxProvider from "@/store/provider";
import { ThemeProvider } from "@/components/theme-provider";
import { Toaster } from "sonner";
import ProgressBar from "@/views/components/ProgressBar";

const geistSans = Geist({
    variable: "--font-geist-sans",
    subsets: ["latin"],
});

const geistMono = Geist_Mono({
    variable: "--font-geist-mono",
    subsets: ["latin"],
});

export const metadata: Metadata = {
    title: "News Aggregator",
    description: "Collecting News from allover the world!",
};

export default function RootLayout({
    children,
}: Readonly<{
    children: React.ReactNode;
}>) {
    return (
        <html lang="en" suppressHydrationWarning>
            <body className={`${geistSans.variable} ${geistMono.variable} antialiased`}>
                <ThemeProvider
                    attribute="class"
                    defaultTheme="system"
                    enableSystem
                    disableTransitionOnChange
                >
                    <ReduxProvider>{children}</ReduxProvider>
                    <Toaster richColors position="top-right" />
                    <ProgressBar />
                </ThemeProvider>
            </body>
        </html>
    );
}
