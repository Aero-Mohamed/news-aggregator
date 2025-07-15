"use client";

import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import RegisterForm from "@/views/forms/RegisterForm";
import Link from "next/link";

export default function RegisterPage() {
    return (
        <div className="flex items-center justify-center mt-15 bg-background">
            <Card className="w-full max-w-md">
                <CardHeader>
                    <CardTitle className="text-2xl text-center">Register</CardTitle>
                    <CardDescription className="text-center">Create a new account</CardDescription>
                </CardHeader>
                <CardContent>
                    <RegisterForm />
                </CardContent>
                <CardFooter className="flex justify-center">
                    <p className="text-sm text-muted-foreground">
                        Already have an account?
                        <Link
                            href="/login"
                            className="px-1 text-primary underline underline-offset-4 hover:text-primary/90"
                        >
                            Login
                        </Link>
                    </p>
                </CardFooter>
            </Card>
        </div>
    );
}
