"use client";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import * as z from "zod";

import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { fetchArticles } from "@/store/articles/thunks";
import { useAppDispatch } from "@/store/hooks";
import { authenticate } from "@/store/auth/thunks";
import { useRouter } from "next/navigation";
import { useSelector } from "react-redux";
import { RootState } from "@/store";
import { Loader2Icon } from "lucide-react";

// Define the form schema with zod
const loginFormSchema = z.object({
    email: z.string().email({ message: "Please enter a valid email address" }),
    password: z.string().min(6, { message: "Password is required" }),
});

// Define the form values type
type LoginFormValues = z.infer<typeof loginFormSchema>;

export default function LoginForm() {
    const router = useRouter();
    const dispatch = useAppDispatch();

    const { loading } = useSelector((state: RootState) => state.auth);

    // Initialize the form with useForm hook
    const form = useForm<LoginFormValues>({
        resolver: zodResolver(loginFormSchema),
        defaultValues: {
            email: "",
            password: "",
        },
    });

    function onSubmit(values: LoginFormValues) {
        dispatch(
            authenticate({
                data: {
                    email: values.email,
                    password: values.password,
                },
            })
        ).then(() => {
            router.replace("/");
        });
    }

    return (
        <>
            <Form {...form}>
                <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-4">
                    <FormField
                        control={form.control}
                        name="email"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel>Email</FormLabel>
                                <FormControl>
                                    <Input placeholder="Enter your email" type="email" {...field} />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        )}
                    />
                    <FormField
                        control={form.control}
                        name="password"
                        render={({ field }) => (
                            <FormItem>
                                <FormLabel>Password</FormLabel>
                                <FormControl>
                                    <Input
                                        placeholder="Enter your password"
                                        type="password"
                                        {...field}
                                    />
                                </FormControl>
                                <FormMessage />
                            </FormItem>
                        )}
                    />
                    {loading && (
                        <Button className="w-full" disabled>
                            <Loader2Icon className="animate-spin" />
                            Please wait
                        </Button>
                    )}
                    {!loading && (
                        <Button type="submit" className="w-full">
                            Login
                        </Button>
                    )}
                </form>
            </Form>
        </>
    );
}
