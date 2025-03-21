// [Pattern: Module + Class-Based Organization]
class SynonymNoteManager {
  constructor() {
    this.processedWords = new Set(); // [Pattern: Cache/Tracking]
    this.notesFetchTimer = null;
    this.maxInitialNotes = 5;
    this.init();
  }

  // [Pattern: Observer] - Sets up all event listeners
  init() {
    $(document).on("click", "#addNoteBtn", () => this.openNoteModal());
    $(document).on("click", "#viewNoteBtn", () => this.viewNote());
    $(document).on("click", "#saveNote", () => this.saveNote());
    $(document).on("click", ".close-note-modal, #closeNote", () => this.closeModal());
    $(document).on("click", ".synonym-word", (e) => {
      const word = $(e.currentTarget).data("word");
      this.debouncedFetchNote(word);
    });
    $(window).on("click", (e) => {
      if ($(e.target).is("#noteModal")) this.closeModal();
    });

    setTimeout(() => this.initializeNotes(), 1000);
  }

  // [Pattern: Debounce]
  debouncedFetchNote(word) {
    if (this.notesFetchTimer) clearTimeout(this.notesFetchTimer);
    if (this.processedWords.has(word)) return;

    this.notesFetchTimer = setTimeout(() => {
      const mid = this.getMasterId();
      console.log(`🔍 Fetching note for: ${word}`);

      // [Pattern: Command]
      $.ajax({
        url: "fetch_note.php",
        type: "POST",
        data: { word, master_id: mid },
        dataType: "json",
        success: (res) => {
          this.processedWords.add(word);
          if (res.success && res.note?.trim() !== "") {
            $(`.synonym-word[data-word='${word}']`).addClass("has-note");
          }
        },
        error: () => this.processedWords.add(word),
      });
    }, 2000);
  }

  openNoteModal() {
    const word = this.getSelectedWord();
    if (!word) return alert("Please select a synonym word first.");

    const mid = this.getMasterId();

    $.ajax({
      url: "fetch_note.php",
      type: "POST",
      data: { word, master_id: mid },
      dataType: "json",
      success: (res) => {
        $("#noteText").val(res.success ? res.note : "");
        $("#noteModal h3").text(`Add Note for "${word}"`);
        $("#noteText").prop("readonly", false);
        $("#saveNote").show();
        $("#noteModal").show();
      },
      error: () => {
        $("#noteText").val("");
        $("#noteModal").show();
      }
    });
  }

  saveNote() {
    const word = this.getSelectedWord();
    const note = $("#noteText").val();
    const mid = this.getMasterId();

    // [Pattern: Command]
    $.ajax({
      url: "save_note.php",
      type: "POST",
      data: { word, note, master_id: mid },
      dataType: "json",
      success: (res) => {
        if (res.success) {
          alert("Note saved successfully!");
          const el = $(`.synonym-word[data-word='${word}']`);
          note.trim() !== "" ? el.addClass("has-note") : el.removeClass("has-note");
          this.closeModal();
        } else {
          alert("Error saving note: " + res.message);
        }
      },
      error: () => alert("Error saving note. Check console for details.")
    });
  }

  viewNote() {
    const word = this.getSelectedWord();
    const mid = this.getMasterId();

    $.ajax({
      url: "fetch_note.php",
      type: "POST",
      data: { word, master_id: mid },
      dataType: "json",
      success: (res) => {
        const msg = res.success && res.note?.trim() !== ""
          ? res.note
          : "No note available for this synonym.";
        $("#noteText").val(msg);
        $("#noteModal h3").text(`View Note for "${word}"`);
        $("#noteText").prop("readonly", true);
        $("#saveNote").hide();
        $("#noteModal").show();
      },
      error: () => alert("Could not retrieve the note.")
    });
  }

  initializeNotes() {
    let count = 0;
    $(".synonym-word.green, .synonym-word.yellow-word").each((_, el) => {
      if (count < this.maxInitialNotes) {
        const word = $(el).data("word");
        if (word && !this.processedWords.has(word)) {
          this.debouncedFetchNote(word);
          count++;
        }
      }
    });
  }

  closeModal() {
    $("#noteModal").hide();
  }

  getSelectedWord() {
    return $("#selected-word").text().trim();
  }

  getMasterId() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get("mid") || 5075;
  }
}

// [Pattern: Module] - Instantiating the note manager as a self-contained unit
$(document).ready(() => {
  new SynonymNoteManager();
});
