import { Skeleton } from "@/components/ui/skeleton";

export default function ArticleCardSkeleton() {
    return (
        <div className="flex flex-col space-y-3 h-52 w-full">
            <Skeleton className="h-40 w-full rounded-xl" />
            <div className="space-y-2">
                <Skeleton className="h-12 w-full" />
                <Skeleton className="h-8 w-full" />
            </div>
        </div>
    );
}
