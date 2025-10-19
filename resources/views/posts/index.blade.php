<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Posts</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      padding: 2rem;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    h1 {
      color: white;
      text-align: center;
      margin-bottom: 2rem;
      font-size: 2.5rem;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .posts-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 1.5rem;
    }

    .post-card {
      background: white;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .post-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    .post-header {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid #f0f0f0;
    }

    .author-avatar {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      margin-right: 0.75rem;
      font-size: 1.2rem;
    }

    .author-info {
      flex: 1;
    }

    .author-name {
      font-weight: 600;
      color: #333;
      font-size: 0.95rem;
    }

    .post-date {
      color: #666;
      font-size: 0.75rem;
    }

    .post-title {
      color: #1a1a1a;
      font-size: 1.25rem;
      font-weight: 600;
      line-height: 1.4;
      margin-bottom: 0.5rem;
    }

    .post-id {
      display: inline-block;
      background: #f0f0f0;
      color: #666;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.75rem;
      margin-top: 0.5rem;
    }

    .no-posts {
      text-align: center;
      color: white;
      font-size: 1.2rem;
      padding: 2rem;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      backdrop-filter: blur(10px);
    }

    @media (max-width: 768px) {
      .posts-grid {
        grid-template-columns: 1fr;
      }

      h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>📝 All Posts</h1>

    @if($posts->count() > 0)
    <div class="posts-grid">
      @foreach($posts as $post)
      <div class="post-card">
        <div class="post-header">
          <div class="author-avatar">
            {{ strtoupper(substr($post->user->name, 0, 1)) }}
          </div>
          <div class="author-info">
            <div class="author-name">{{ $post->user->name }}</div>
            <div class="post-date">{{ $post->created_at->format('M d, Y') }}</div>
          </div>
        </div>
        <h2 class="post-title">{{ $post->title }}</h2>
        <span class="post-id">ID: {{ $post->id }}</span>
      </div>
      @endforeach
    </div>
    @else
    <div class="no-posts">
      No posts available yet. Create some posts to see them here!
    </div>
    @endif
  </div>
</body>

</html>
