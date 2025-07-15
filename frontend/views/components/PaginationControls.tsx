"use client";

import {
    Pagination,
    PaginationContent,
    PaginationItem,
    PaginationNext,
    PaginationPrevious,
} from "@/components/ui/pagination";
import { Button } from "@/components/ui/button";

type PaginationControlsProps = {
    currentPage: number;
    totalPages: number;
    onPageChangeAction: (page: number) => void;
};

export default function PaginationControls({
    currentPage,
    totalPages,
    onPageChangeAction,
}: PaginationControlsProps) {
    const goToPage = (page: number) => {
        if (page >= 1 && page <= totalPages) {
            onPageChangeAction(page);
        }
    };

    return (
        <Pagination className="mt-2 mb-10">
            <PaginationContent>
                <PaginationItem>
                    <Button
                        className="hover:cursor-pointer"
                        variant="outline"
                        onClick={() => goToPage(currentPage - 1)}
                        disabled={currentPage === 1}
                    >
                        <PaginationPrevious />
                    </Button>
                </PaginationItem>

                <PaginationItem>
                    <div className="px-4 text-sm text-muted-foreground">
                        Page {currentPage} of {totalPages}
                    </div>
                </PaginationItem>

                <PaginationItem>
                    <Button
                        className="hover:cursor-pointer"
                        variant="outline"
                        onClick={() => goToPage(currentPage + 1)}
                        disabled={currentPage === totalPages}
                    >
                        <PaginationNext />
                    </Button>
                </PaginationItem>
            </PaginationContent>
        </Pagination>
    );
}
