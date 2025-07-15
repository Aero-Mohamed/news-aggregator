"use client";

import { format } from "date-fns";
import { cn } from "@/lib/utils";
import {
    Form,
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
    FormDescription,
} from "@/components/ui/form";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";

import { Button } from "@/components/ui/button";
import { CalendarIcon } from "lucide-react";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { useForm } from "react-hook-form";
import * as z from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { useState } from "react";
import { useRouter, useSearchParams } from "next/navigation";
import { Source } from "@/store/articles/types";

const filterSchema = z.object({
    sourceId: z.string().optional(),
    dateFrom: z.date().optional(),
    dateTo: z.string().optional(),
});

// Hardcoded sources for the dropdown
const sources: Source[] = [
    { id: "1", name: "CNN" },
    { id: "2", name: "BBC" },
    { id: "3", name: "The New York Times" },
    { id: "4", name: "The Guardian" },
    { id: "5", name: "Reuters" },
];

export default function ArticleFilter() {
    const router = useRouter();
    const searchParams = useSearchParams();

    //const pageParam = parseInt(searchParams.get("page") || "1", 10);
    // const sourceIdParam = searchParams.get("source_id") || "";
    // const dateFromParam = searchParams.get("date_from") || "";
    // const dateToParam = searchParams.get("date_to") || "";

    // State for filters
    const [sourceId, setSourceId] = useState<string>();
    const [dateFrom, setDateFrom] = useState<string>();
    const [dateTo, setDateTo] = useState<string>();

    const form = useForm({
        resolver: zodResolver(filterSchema),
    });

    const onSubmit = (values: any) => {};

    const handleClearFilters = () => {};

    return (
        <Form {...form}>
            <form
                onSubmit={form.handleSubmit(onSubmit)}
                className="mt-4 p-4 rounded-lg shadow mb-4 border"
            >
                <h2 className="text-lg font-semibold mb-4">Filter Articles</h2>
                <div className="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <FormField
                        control={form.control}
                        name="sourceId"
                        render={({ field }) => (
                            <FormItem className="w-full">
                                <FormLabel>Source</FormLabel>
                                <Select onValueChange={field.onChange} value={field.value ?? ""}>
                                    <FormControl>
                                        <SelectTrigger className="w-full">
                                            <SelectValue placeholder="All Sources" />
                                        </SelectTrigger>
                                    </FormControl>
                                    <SelectContent>
                                        <SelectItem value="all">All Sources</SelectItem>
                                        {sources.map(source => (
                                            <SelectItem key={source.id} value={source.id}>
                                                {source.name}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                            </FormItem>
                        )}
                    />
                    <FormField
                        control={form.control}
                        name="dateFrom"
                        render={({ field }) => (
                            <FormItem className="flex flex-col w-full">
                                <FormLabel>Date From</FormLabel>
                                <Popover>
                                    <PopoverTrigger asChild>
                                        <FormControl>
                                            <Button
                                                variant={"outline"}
                                                className={cn(
                                                    "w-full pl-3 text-left font-normal",
                                                    !field.value && "text-muted-foreground"
                                                )}
                                            >
                                                {field.value ? (
                                                    format(field.value, "PPP")
                                                ) : (
                                                    <span>Pick a date</span>
                                                )}
                                                <CalendarIcon className="ml-auto h-4 w-4 opacity-50" />
                                            </Button>
                                        </FormControl>
                                    </PopoverTrigger>
                                    <PopoverContent className="w-auto p-0" align="start">
                                        <Calendar
                                            mode="single"
                                            selected={field.value}
                                            onSelect={field.onChange}
                                            disabled={date =>
                                                date > new Date() || date < new Date("1900-01-01")
                                            }
                                            captionLayout="dropdown"
                                        />
                                    </PopoverContent>
                                </Popover>
                                <FormMessage />
                            </FormItem>
                        )}
                    />
                </div>

                <div className="mt-4 flex gap-2">
                    <Button type="submit">Apply Filters</Button>
                    <Button type="button" variant="secondary" onClick={handleClearFilters}>
                        Clear Filters
                    </Button>
                </div>
            </form>
        </Form>
    );
}
