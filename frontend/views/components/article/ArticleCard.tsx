"use client";

import { Card, CardContent, CardFooter, CardHeader } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import Image from "next/image";
import Link from "next/link";
import { Article } from "@/store/articles/types";

interface Props {
    article: Article;
}

export default function ArticleCard({ article }: Props) {
    return (
        <Card className="w-full overflow-hidden flex flex-col justify-between shadow-sm rounded-2xl pt-0 pb-1">
            <CardHeader className="p-0">
                <Link href={article.url} target="_blank" rel="noopener noreferrer">
                    <div className="relative w-full h-48">
                        <div className="absolute top-2 left-2 z-10  flex flex-wrap gap-1 mt-2">
                            {article.categories?.map(cat => (
                                <Badge
                                    key={cat.id}
                                    className="font-bold drop-shadow-lg bg-slate-100 text-slate-900 "
                                >
                                    {cat.name}
                                </Badge>
                            ))}
                        </div>
                        <Image
                            src={article.image_url || "/article-placeholder.png"}
                            alt={article.title}
                            fill
                            className="object-cover"
                            sizes="(min-width: 768px) 50vw, 100vw"
                            priority
                        />
                    </div>
                </Link>
            </CardHeader>

            <CardContent className="p-4 py-0 space-y-2 flex-1">
                <span className="text-muted-foreground text-xs">
                    {new Date(article.published_at).toLocaleDateString()}
                </span>
                <Link href={article.url} target="_blank" rel="noopener noreferrer">
                    <h3 className="text-lg font-semibold leading-tight line-clamp-2">
                        {article.title}
                    </h3>
                </Link>
                {(article.description || article.content) && (
                    <p className="text-muted-foreground text-sm line-clamp-3 mt-3">
                        {article.description || article.content}
                    </p>
                )}
            </CardContent>

            <CardFooter className="p-4 flex items-center justify-between text-xs text-muted-foreground">
                <span>
                    <div className="flex flex-wrap gap-1 mt-2">
                        <span className="mt-1 ">By</span>
                        {article.authors?.slice(0, 2).map(author => (
                            <Badge key={author.id} variant="outline">
                                {author.name.length > 15
                                    ? author.name.slice(0, 15) + "…"
                                    : author.name}
                            </Badge>
                        ))}
                    </div>
                </span>
                <span>{article.source?.name}</span>
            </CardFooter>
        </Card>
    );
}
