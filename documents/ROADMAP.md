## Development Roadmap – Bad-Trello (Symfony UX)

This roadmap outlines a progressive development plan for a Trello-like task manager using Symfony 7.3 and Symfony UX. It focuses on modularity, modern UX patterns, and clean backend design.

---

### Phase 0 – Project Initialization

- Initialize a new Symfony project with web assets
- Install the required dependencies:
  - Doctrine ORM
  - Twig
  - Symfony UX packages (Stimulus, Turbo, Twig Components)
- Create a base layout file for the application

---

### Phase 1 – Data Modeling

- Create entity `Project` with a title field
- Create entity `Column` with:
  - Title
  - Position (for ordering)
  - Many-to-one relation to `Project`
- Create entity `Card` with:
  - Title
  - Description
  - isDone (boolean)
  - Position
  - Many-to-one relation to `Column`
- Run migrations to update the database
- Create initial fixtures for testing

---

### Phase 2 – UI Rendering (Static)

- Create a project view page displaying:
  - All columns associated with the project
  - All cards within each column
- Use Twig Components to encapsulate:
  - Column rendering logic
  - Card rendering logic
- Apply basic styling using SCSS or TailwindCSS

---

### Phase 3 – Dynamic Card Management (Stimulus)

- Add a card creation form to each column
- Create a Stimulus controller to handle:
  - Form submission via fetch
  - DOM updates without page reload
- Reset the form upon successful creation
- Add visual confirmation (e.g., flash message or highlight)

---

### Phase 4 – Task Completion Toggle

- Add a toggle (button or checkbox) to mark cards as completed
- Update the card's state using Turbo or Stimulus fetch
- Apply styling for completed cards (e.g., strikethrough or reduced opacity)

---

### Phase 5 – Card Deletion

- Add a delete button to each card
- Handle card deletion dynamically via Stimulus or Turbo
- Remove the card from the DOM upon confirmation

---

### Phase 6 – Drag and Drop Support

- Integrate a drag-and-drop library (e.g., sortablejs)
- Enable card reordering within a column
- Enable moving cards between columns
- Update card positions and column associations on the server
- Apply smooth animations or feedback for drag actions

---

### Phase 7 – User Authentication (Optional)

- Implement user registration and login
- Link projects to their creators
- Restrict access to projects using security rules
- Add project-level access control with `is_granted`

---

### Phase 8 – Advanced Features (Optional)

- Add tags or labels to cards
- Implement due dates and task filtering
- Allow column reordering
- Support inline editing (using UX Live Components)
- Build a REST API for external clients
- Add a responsive mobile-first layout
- Implement project sharing and collaboration features

---

### Quality and Security Guidelines

- Use CSRF protection on all forms
- Validate all user input with Symfony constraints
- Apply `is_granted` and access control on sensitive routes
- Keep components and controllers small and te
