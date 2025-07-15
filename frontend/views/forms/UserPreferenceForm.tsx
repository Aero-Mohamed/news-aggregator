import { z } from "zod";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form";
import { Button } from "@/components/ui/button";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Command, CommandGroup, CommandItem } from "@/components/ui/command";
import { Check, ChevronsUpDown } from "lucide-react";
import { cn } from "@/lib/utils";
import { useState } from "react";

const formSchema = z.object({
    sources: z.array(z.string()).min(1, "Select at least one source."),
});

type FormValues = z.infer<typeof formSchema>;

const AVAILABLE_SOURCES = [
    { label: "Twitter", value: "twitter" },
    { label: "Reddit", value: "reddit" },
    { label: "Medium", value: "medium" },
    { label: "YouTube", value: "youtube" },
];

export function UserPreferenceForm({ onSubmit }: { onSubmit: (data: FormValues) => void }) {
    const form = useForm<FormValues>({
        resolver: zodResolver(formSchema),
        defaultValues: { sources: [] },
    });

    const selectedValues = form.watch("sources");

    return (
        <Form {...form}>
            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-6">
                <FormField
                    control={form.control}
                    name="sources"
                    render={({ field }) => (
                        <FormItem className="flex flex-col w-full">
                            <FormLabel>Preferred Sources</FormLabel>
                            <Popover>
                                <PopoverTrigger asChild>
                                    <FormControl>
                                        <Button
                                            variant="outline"
                                            role="combobox"
                                            className={cn(
                                                "w-full justify-between",
                                                !field.value.length && "text-muted-foreground"
                                            )}
                                        >
                                            {field.value.length > 0
                                                ? AVAILABLE_SOURCES.filter(opt =>
                                                      field.value.includes(opt.value)
                                                  )
                                                      .map(opt => opt.label)
                                                      .join(", ")
                                                : "Select sources"}
                                            <ChevronsUpDown className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                        </Button>
                                    </FormControl>
                                </PopoverTrigger>
                                <PopoverContent className="w-full p-0">
                                    <Command className="w-full">
                                        <CommandGroup className="w-full">
                                            {AVAILABLE_SOURCES.map(source => {
                                                const isSelected = field.value.includes(
                                                    source.value
                                                );
                                                return (
                                                    <CommandItem
                                                        key={source.value}
                                                        onSelect={() => {
                                                            const newValues = isSelected
                                                                ? field.value.filter(
                                                                      v => v !== source.value
                                                                  )
                                                                : [...field.value, source.value];
                                                            field.onChange(newValues);
                                                        }}
                                                        className="w-full px-3 py-2 flex justify-between items-center"
                                                    >
                                                        <span>{source.label}</span>
                                                        <Check
                                                            className={cn(
                                                                "h-4 w-4",
                                                                isSelected
                                                                    ? "opacity-100"
                                                                    : "opacity-0"
                                                            )}
                                                        />
                                                    </CommandItem>
                                                );
                                            })}
                                        </CommandGroup>
                                    </Command>
                                </PopoverContent>
                            </Popover>
                            <FormMessage />
                        </FormItem>
                    )}
                />

                <Button type="submit">Save Preferences</Button>
            </form>
        </Form>
    );
}
