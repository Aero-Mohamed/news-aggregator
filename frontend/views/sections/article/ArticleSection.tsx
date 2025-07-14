"use client";

import { useSelector } from "react-redux";
import { useAppDispatch } from "@/store/hooks";
import ArticleCard from "@/views/components/article/ArticleCard";
import { RootState } from "@/store";
import { useEffect } from "react";
import { fetchArticles } from "@/store/articles/thunks";
import ArticleCardSkeleton from "@/views/components/article/ArticleCardSkeleton";
import { useSearchParams, useRouter } from "next/navigation";
import PaginationControls from "@/views/components/PaginationControls";

export default function ArticleSection() {
    const dispatch = useAppDispatch();
    const searchParams = useSearchParams();
    const router = useRouter();

    const { articles, meta, loading } = useSelector((state: RootState) => state.articles);
    const pageParam = parseInt(searchParams.get("page") || "1", 10);

    useEffect(() => {
        dispatch(
            fetchArticles({
                query: { page: pageParam || 1 },
            })
        );
    }, [dispatch, pageParam]);

    const handlePageChange = (page: number) => {
        const params = new URLSearchParams(searchParams);
        params.set("page", String(page));
        router.push(`?${params.toString()}`);
    };

    if (loading) {
        return (
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 p-4">
                {[...Array(15)].map((_, i) => (
                    <ArticleCardSkeleton key={i} />
                ))}
            </div>
        );
    }

    return (
        <>
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 p-4">
                {articles?.map((article: any) => (
                    <ArticleCard key={article.id} article={article} />
                ))}
            </div>
            <PaginationControls
                currentPage={meta.current_page}
                totalPages={meta.total}
                onPageChangeAction={handlePageChange}
            />
        </>
    );
}
