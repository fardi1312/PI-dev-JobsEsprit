<?php
namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\File;

class FileToStringTransformer implements DataTransformerInterface
{
    public function transform($value): string
    {
        // transform the File to a string for the form field
        if ($value instanceof File) {
            // Assuming you want to display the file name in the form
            return $value->getFilename();
        }

        return '';
    }

    public function reverseTransform($value): ?File
    {
        // transform the string back to a File for the entity
        if (!$value) {
            return null;
        }

        // Assuming you have a method to handle file upload
        // in your Covoiturage entity (e.g., setFile)
        // Adjust this based on your file upload logic
        return new File($value);
    }
}