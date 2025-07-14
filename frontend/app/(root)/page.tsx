import ArticleSection from "@/views/sections/article/ArticleSection";
import { Suspense } from "react";

export default function Home() {
    return (
        <div className="mx-auto container">
            <Suspense fallback={<div>Loading pagination...</div>}>
                <ArticleSection />
            </Suspense>
        </div>
    );
}
