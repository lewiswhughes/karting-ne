const { InspectorControls } = wp.editor;
const { registerBlockType } = wp.blocks;
const { withSelect } = wp.data;

registerBlockType( 'surgems/latest-posts', {
    title: 'Latest Posts',
    icon: 'heart',
    category: 'widgets',

    edit: withSelect( ( select ) => {
      let query = {
        per_page: 1
      }

      return {
        posts: select( 'core' ).getEntityRecords( 'postType', 'post', query )
      };

    } )( ( { posts, className } ) => {

      if ( ! posts ) {
          return "Loading...";
      }

      if ( posts && posts.length === 0 ) {
          return "No posts to retrieve";
      }

      let content = posts.map( (post) => {
        return <article className="post">
                <h2 dangerouslySetInnerHTML={ { __html: post.title.rendered } }></h2>
                <div dangerouslySetInnerHTML={ { __html: post.excerpt.rendered } }></div>
                <a href={ post.permalink }>View Details</a>
              </article>
      })

      return <section className="latest-posts">{ content }</section>;

    } ),

    save() {
        // Rendering in PHP
        return null;
    },
} );
