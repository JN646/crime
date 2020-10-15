package com.example.a8ball2

// Imports
import android.support.v7.app.AppCompatActivity
import android.os.Bundle
import android.widget.Button
import android.widget.TextView
import kotlinx.android.synthetic.main.activity_main.*

// Main Class
class MainActivity : AppCompatActivity() {

    // On Create
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        // get reference to button
        val btn_click_me = findViewById(R.id.btn_click_me) as Button

        // Click Button
        btn_click_me.setOnClickListener {
            randomOutput()
        }

        // Click image.
        imgBall.setOnClickListener {
            randomOutput()
        }
    }

    fun randomOutput() {
        var txtOutput = findViewById<TextView>(R.id.txtOutput)
        val strings = arrayOf("It is certain.", "It is decidedly so.", "Without a doubt.", "Yes - definitely.", "You may rely on it.", "As I see it, yes.", "Most likely.", "Outlook good.", "Yes.", "Signs point to yes.", "Reply hazy, try again.", "Ask again later.", "Better not tell you now.", "Cannot predict now.", "Concentrate and ask again.", "Don't count on it.", "My reply is no.", "My sources say no.", "Outlook not so good.", "Very doubtful.")

        // Choose random number
        val rnds = (0..19).random()

        // Set the text
        txtOutput.text = strings[rnds]
    }
}
