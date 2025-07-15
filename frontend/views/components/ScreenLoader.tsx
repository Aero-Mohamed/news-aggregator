"use client";

import React from "react";
import { useSelector } from "react-redux";
import { RootState } from "@/store";

export default function ScreenLoader() {
    const loading = useSelector((state: RootState) => state.ui.loading);

    if (!loading) return null;

    return (
        <>
            <div className="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 z-[9999] flex items-center justify-center">
                <div className="h-12 w-12 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
            </div>
        </>
    );
}
