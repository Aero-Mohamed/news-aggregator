import { NextResponse } from "next/server";
import type { NextRequest } from "next/server";

const AuthRedirectTo = "/";
const UnAuthRedirectTo = "/login";

export function middleware(request: NextRequest) {
    const token = request.cookies.get("token"); // Use your actual cookie name

    const isAuth: boolean = !!token;
    const isAuthPage: boolean =
        request.nextUrl.pathname === "/login" || request.nextUrl.pathname === "/register";

    if (isAuth && isAuthPage) {
        console.log("isAuthPage", isAuthPage);
        return NextResponse.redirect(new URL(AuthRedirectTo, request.url));
    }

    if (!isAuth && PROTECTED_ROUTES.includes(request.nextUrl.pathname)) {
        return NextResponse.redirect(new URL(UnAuthRedirectTo, request.url));
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
