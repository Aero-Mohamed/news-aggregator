"use client";

import { useSelector } from "react-redux";
import { useAppDispatch } from "@/store/hooks";
import ArticleCard from "@/views/components/article/ArticleCard";
import { Skeleton } from "@/components/ui/skeleton";
import { RootState } from "@/store";
import { useEffect } from "react";
import { fetchArticles } from "@/store/articles/thunks";

export default function ArticleSection() {
    const dispatch = useAppDispatch();
    const { articles, meta, loading } = useSelector((state: RootState) => state.articles);

    useEffect(() => {
        dispatch(fetchArticles());
    }, [dispatch]);

    if (loading) {
        return (
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                {[...Array(6)].map((_, i) => (
                    <Skeleton key={i} className="h-40 w-full" />
                ))}
            </div>
        );
    }

    return (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
            {articles?.map((article: any) => (
                <ArticleCard key={article.id} article={article} />
            ))}
        </div>
    );
}
