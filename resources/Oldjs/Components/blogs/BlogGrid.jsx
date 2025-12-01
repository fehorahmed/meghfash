import {Link } from "@inertiajs/react";

export default function BlogGrid({blog}) {
  return (
    <div class="blog__items">
        <div class="blog__thumbnail">
            <Link class="blog__thumbnail--link" href={route('blogView', blog.slug)}>
                <img class="blog__thumbnail--img" src={blog.image_url} alt={blog.name} />
            </Link>
        </div>
        <div class="blog__content">
            <span class="blog__content--meta">{blog.createdAt}</span>
            <h3 class="blog__content--title"><Link href={route('blogView', blog.slug)}>{blog.name}</Link></h3>
            <Link class="blog__content--btn primary__btn" href={route('blogView', blog.slug)}>Read more  </Link>
        </div>
    </div>
  )
}
