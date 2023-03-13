export const postItem = (post) => {
  return `
  <a href="${post.permalink}" class="PostItem">
    <article class="PostItem--inner">
        <div class="PostItem__image">
        ${post.image ? '<img src="' + post.image + '"/>' : ''}
        </div>
        <div class="PostItem__text-group">
            <div class="PostItem__categories">
            ${post.categories
              .map((key) => {
                return "<p class='PostItem__category'>" + key + '</p>'
              })
              .join('')}
            </div>

            <h5 class="PostItem__title">${post.title}</h5>
        
            <p class="PostItem__date">
                 ${post.date}
                <span class="PostItem__readtime">
                ${post.readTime ? '| ' + post.readTime + 'min read' : ''} 
                </span>
            </p>

            <p class="PostItem__desc">${post.quote}</p>

            <button class="btn--underline PostItem__btn">Full Article</button>
        </div>
    </article>
</a>`
}
