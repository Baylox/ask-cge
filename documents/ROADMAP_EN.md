## Development Roadmap – MiniTrello (Symfony UX)

This roadmap outlines a progressive development plan for a Trello-like task manager using Symfony 6.4+ and Symfony UX. It focuses on modularity, modern UX patterns, and clean backend design.

---

### Phase 0 – Project Initialization

- Initialize a new Symfony project with web assets
- Install required dependencies:
  - Doctrine ORM
  - Twig
  - Symfony UX (Stimulus, Turbo, Twig Components)
- Configure the database (MySQL or SQLite)
- Create a base layout template

---

### Phase 1 – Data Modeling

- Create the `Project` entity with a title field
- Create the `Column` entity with:
  - Title
  - Position (for ordering)
  - Many-to-one relation to `Project`
- Create the `Card` entity with:
  - Title
  - Description
  - isDone (boolean)
  - Position
  - Many-to-one relation to `Column`
- Run database migrations
- Create fixtures for test data

---

### Phase 2 – Static UI Rendering

- Create the project page displaying:
  - All columns in the project
  - All cards in each column
- Use Twig Components to encapsulate:
  - Column rendering
  - Card rendering
- Apply basic styling using SCSS or TailwindCSS

---

### Phase 3 – Dynamic Card Management

- Add a form to create cards inside each column
- Create a Stimulus controller to:
  - Submit the form via fetch
  - Insert the new card into the DOM
- Reset the form after successful submission
- Display visual confirmation (e.g. flash message or highlight)

---

### Phase 4 – Task Completion Toggle

- Add a toggle button or checkbox for task completion
- Update card state dynamically using Turbo or Stimulus
- Apply visual changes (e.g. strikethrough, faded color)

---

### Phase 5 – Card Deletion

- Add a delete button on each card
- Handle deletion via fetch or Turbo
- Remove the card from the DOM after confirmation

---

### Phase 6 – Drag and Drop

- Integrate a drag-and-drop library (e.g. `sortablejs`)
- Allow cards to be reordered within a column
- Allow cards to be moved between columns
- Update card positions and column assignments on the server

---

### Phase 7 – Authentication (Optional)

- Implement user login and registration
- Associate projects with users
- Restrict access to projects using security rules
- Use `is_granted()` to manage permissions

---

### Phase 8 – Optional Features

- Add card tags or labels
- Set due dates and implement filters
- Enable column reordering
- Add inline editing using Symfony UX Live Components
- Expose a REST API for mobile clients
- Make the layout fully responsive
- Add project sharing and team collaboration

---

### Quality & Security Checklist

- CSRF protection on all forms
- Symfony validation constraints on user input
- Access control via `security.yaml` and annotations
- Separation of concerns (Controller, Service, Template)
- Graceful degradation if JS is disabled

