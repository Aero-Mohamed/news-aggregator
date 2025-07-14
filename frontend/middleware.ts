import { NextResponse } from "next/server";
import type { NextRequest } from "next/server";

export function middleware(request: NextRequest) {
    const token = request.cookies.get("token"); // Use your actual cookie name

    const isAuth: boolean = !!token;
    const isAuthPage: boolean =
        request.nextUrl.pathname === "/login" || request.nextUrl.pathname === "/register";

    if (isAuth && isAuthPage) {
        return NextResponse.redirect(new URL("/dashboard", request.url));
    }

    if (!isAuth && PROTECTED_ROUTES.includes(request.nextUrl.pathname)) {
        return NextResponse.redirect(new URL("/login", request.url));
    }

    return NextResponse.next();
}

const PROTECTED_ROUTES = [
    "/dashboard",
    // add more protected paths
];

export const config = {
    matcher: ["/login", "/register", "/dashboard"],
};
