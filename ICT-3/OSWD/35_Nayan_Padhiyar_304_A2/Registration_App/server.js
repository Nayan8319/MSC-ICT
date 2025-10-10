const express = require("express");
const path = require("path");
const multer = require("multer");
const { body, validationResult } = require("express-validator");
const fs = require("fs");

const app = express();
app.set("view engine", "ejs");
app.use(express.urlencoded({ extended: true }));

// Multer Storage
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, "uploads/");
  },
  filename: (req, file, cb) => {
    cb(null, Date.now() + "-" + file.originalname);
  }
});

const upload = multer({ storage });

// Routes
app.get("/", (req, res) => {
  res.render("form", { errors: [], old: {} });
});

app.post(
  "/register",
  upload.fields([{ name: "profilePic", maxCount: 1 }, { name: "otherPics", maxCount: 5 }]),
  [
    body("username").notEmpty().withMessage("Username is required"),
    body("password").isLength({ min: 6 }).withMessage("Password must be at least 6 characters"),
    body("confirmPassword").custom((value, { req }) => {
      if (value !== req.body.password) {
        throw new Error("Passwords do not match");
      }
      return true;
    }),
    body("email").isEmail().withMessage("Invalid email"),
    body("gender").notEmpty().withMessage("Select gender"),
    body("hobbies").notEmpty().withMessage("Select at least one hobby")
  ],
  (req, res) => {
    const errors = validationResult(req);

    if (!errors.isEmpty() || !req.files["profilePic"] || !req.files["otherPics"]) {
      let fileErrors = [];
      if (!req.files["profilePic"]) fileErrors.push({ msg: "Profile picture required" });
      if (!req.files["otherPics"]) fileErrors.push({ msg: "At least one other picture required" });

      return res.render("form", {
        errors: errors.array().concat(fileErrors),
        old: req.body
      });
    }

    const data = {
      username: req.body.username,
      email: req.body.email,
      gender: req.body.gender,
      hobbies: Array.isArray(req.body.hobbies) ? req.body.hobbies.join(", ") : req.body.hobbies,
      profilePic: req.files["profilePic"][0].filename,
      otherPics: req.files["otherPics"].map(f => f.filename)
    };

    // Save data to file for download
    const fileContent = `
      Username: ${data.username}
      Email: ${data.email}
      Gender: ${data.gender}
      Hobbies: ${data.hobbies}
    `;
    fs.writeFileSync("user_data.txt", fileContent);

    res.render("success", { data });
  }
);

// Download Route
app.get("/download", (req, res) => {
  res.download(path.join(__dirname, "user_data.txt"));
});

app.use("/uploads", express.static("uploads"));

app.listen(3000, () => console.log("Server running at http://localhost:3000"));
