"use client";

import { useEffect } from "react";
import { usePathname, useSearchParams } from "next/navigation";
import NProgress from "nprogress";
import "nprogress/nprogress.css";

NProgress.configure({ showSpinner: false });

export default function ProgressBar() {
    const pathname = usePathname();
    const searchParams = useSearchParams();

    useEffect(() => {
        NProgress.start();

        // Timeout helps smooth transition (like debounce)
        const timeout = setTimeout(() => {
            NProgress.done();
        }, 300);

        return () => {
            clearTimeout(timeout);
        };
    }, [pathname, searchParams]);

    return null;
}
