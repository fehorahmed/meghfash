import React from 'react'
import BlogGrid from './BlogGrid'

export default function BlogRelated({relatedBlog}) {
  return (
    <div class="related__post--area">
        <div class="section__heading text-center mb-30">
            <h2 class="section__heading--maintitle">Related Articles </h2>
        </div>
        <div class="row row-cols-md-2 row-cols-sm-2 row-cols-sm-u-2 row-cols-1 mb--n28">
            {relatedBlog.map((blog, index) => (
            <div class="col mb-28">
                <BlogGrid key={index} blog={blog} />
            </div>
            ))}
        </div>
    </div>
  )
}
