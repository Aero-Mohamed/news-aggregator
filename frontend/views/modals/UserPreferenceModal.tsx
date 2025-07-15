import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Settings } from "lucide-react";
import { useState } from "react";
import { UserPreferenceForm } from "@/views/forms/UserPreferenceForm";

export function UserPreferenceModal() {
    const [open, setOpen] = useState(false);

    const handleSubmit = (data: any) => {
        console.log("User Preferences Submitted:", data);
        setOpen(false);
    };

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <Button variant="ghost" size="icon">
                    <Settings className="h-5 w-5" />
                </Button>
            </DialogTrigger>
            <DialogContent className="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>User Preferences</DialogTitle>
                </DialogHeader>
                <UserPreferenceForm onSubmit={handleSubmit} />
            </DialogContent>
        </Dialog>
    );
}
